<?php
/**
 * Class CProtocol
 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------               ----------                  ----------
 * __construct                                          unmarshal
 * connect2delivery                                     marshal
 * connect2provider
 * connect2gamedbd
 * parseOctet
 * loadStructure
 * connect
 * write
 * read
 *
 * STATIC:
 * ---------------------------------------------------------------
 * init
 *
 */
class CProtocol extends CComponent
{
    use BinaryRead;
    use BinaryWrite;

    /** @var null|resource */
    private $socket = null;
    /** @var bool */
    private $vector = false;

    const DOMAIN = '127.0.0.1';
    const GDELIVERY = 29100;
    const GPROVIDER = 29300;
    const GAMEDBD = 29400;

    /**
     * Class default constructor
     */
    function __construct()
    {
        if(version_compare(PHP_VERSION, '5.4.0', '<')){
            exit('Required PHP version - 5.4.0 (current version - '.PHP_VERSION.')');
        }
    }

    /**
     * Returns the instance of object
     * @return CProtocol class
     */
    public static function init()
    {
        return parent::init(__CLASS__);
    }

    /**
     * Initiates a connection on a socket
     */
    public function connect2delivery()
    {
        if(!$this->connect(self::DOMAIN, self::GDELIVERY)) exit('Can\'t connect to gdelivery.');
    }

    /**
     * Initiates a connection on a socket
     */
    public function connect2provider()
    {
        if(!$this->connect(self::DOMAIN, self::GPROVIDER)) exit('Can\'t connect to gprovider.');
    }

    /**
     * Initiates a connection on a socket
     */
    public function connect2gamedbd()
    {
        if(!$this->connect(self::DOMAIN, self::GAMEDBD)) exit('Can\'t connect to gamedbd.');
    }

    /**
     * @param string $octet
     * @param array $structure
     * @param bool $resetPosition
     * @return array
     */
    public function parseOctet($octet, array $structure, $resetPosition = true)
    {
        $octet = pack('H*', $octet);
        if($resetPosition) $this->pointer = 0;
        return $this->unmarshal($octet, $structure);
    }

    /**
     * @param $version
     * @return mixed|string
     */
    public function loadStructure($version)
    {
        $path = str_replace('.', DS, $version);
        $file = APP_PATH.DS.'protected'.DS.'data'.DS.'struct'.DS.$path.'.php';
        if(file_exists($file)){
            return include($file);
        }
        return '';
    }

    /**
     * Create a socket
     * @param $address
     * @param $port
     * @return bool
     */
    public function connect($address = '127.0.0.1', $port)
    {
        if(false===($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))){
            exit('Unable to create AF_INET socket.');
        }
        if(socket_connect($this->socket, $address, $port)){
            return true;
        }
        return false;
    }

    /**
     * Closes a socket resource
     */
    public function close()
    {
        if($this->socket !== null) socket_close($this->socket);
    }

    /**
     * @param $type
     * @param array $data
     * @param array $structure
     * @param bool $RecvBeforeSend
     * @return $this
     */
    public function write($type, array $data, array $structure, $RecvBeforeSend = false)
    {
        $data = $this->marshal($data, $structure);
        $packet = $this->WriteCUInt($type).$this->WriteCUInt(strlen($data)).$data;
        if($RecvBeforeSend) socket_recv($this->socket, $tmp, 8192, 0);
        //socket_send($this->socket, $packet, strlen($packet), 0);
        if(!socket_write($this->socket, $packet)){
            return false;
        }
        return $this;
    }

    /**
     * @param array $structure
     * @param bool $binaryOnly
     * @return array
     */
    public function read(array $structure = [], $binaryOnly = false)
    {
        $this->pointer = 0;
        $buffer = socket_read($this->socket, 1024, PHP_BINARY_READ);

        $opcode = $this->ReadCUInt($buffer);
        $size = $this->ReadCUInt($buffer);

        //echo 'opcode: '.$opcode.'<br>';
        //echo 'size: '.$size.'<br>';

        while(strlen($buffer) < $size){
            $buffer .= socket_read($this->socket, 1024, PHP_BINARY_READ);
        }

        if($this->socket !== null) socket_close($this->socket);

        if($binaryOnly===false){
            return $this->unmarshal($buffer, $structure);
        }else{
            return bin2hex($buffer);
        }
    }

    /**
     * @param $data
     * @param $structure
     * @return array
     */
    private function unmarshal($data, array $structure)
    {
        $result = [];
        $this->vector = false;

        foreach($structure as $key => $value){
            if(is_array($value)){
                if($this->vector){
                    $count = $this->ReadCUInt($data);
                    for($i = 0; $i < $count; $i++){
                        $result[$key][$i] = $this->unmarshal($data, $value);
                    }

                    $this->vector = false;
                }else{
                    $result[$key] = $this->unmarshal($data, $value);
                }
            }else{
                switch($value){
                    case 'byte':
                        $result[$key] = $this->ReadByte($data);
                        break;
                    case 'short':
                        $result[$key] = $this->ReadInt16($data);
                        break;
                    case 'short_l':
                        $result[$key] = $this->ReadInt16LE($data);
                        break;
                    case 'int':
                        $result[$key] = $this->ReadInt32($data);
                        break;
                    case 'int_l':
                        $result[$key] = $this->ReadInt32LE($data);
                        break;
                    case 'long':
                    case 'int64':
                        $result[$key] = $this->ReadInt64($data);
                        break;
                    case 'string':
                        $result[$key] = $this->ReadString($data);
                        break;
                    case 'octets':
                        $result[$key] = $this->ReadOctet($data);
                        break;
                    case 'float':
                        $result[$key] = $this->ReadFloat($data);
                        break;
                    case 'float_nr':
                        $result[$key] = $this->ReadFloat($data, false);
                        break;
                    case 'vector':
                        $this->vector = true;
                        break;
                    case 'cuint':
                        $result[$key] = $this->ReadCUInt($data);
                        break;
                }
            }
        }
        return $result;
    }

    /**
     * @param $data
     * @param $structure
     * @return string
     */
    private function marshal(array $data, array $structure)
    {
        $result = '';
        $this->vector = false;

        foreach($structure as $key => $value){
            if(is_array($value)){
                if($this->vector){
                    $count = isset($data[$key]) ? count($data[$key]) : 0;
                    $result .= $this->WriteCUInt($count);
                    for($i = 0; $i < $count; $i++){
                        $result .= $this->marshal($data[$key][$i], $value);
                    }

                    $this->vector = false;
                }else{
                    $result .= $this->marshal($data[$key], $value);
                }
            }else{
                switch($value){
                    case 'byte':
                        $result .= $this->WriteByte($data[$key]);
                        break;
                    case 'short':
                        $result .= $this->WriteInt16($data[$key]);
                        break;
                    case 'short_l':
                        $result .= $this->WriteInt16LE($data[$key]);
                        break;
                    case 'int':
                        $result .= $this->WriteInt32($data[$key]);
                        break;
                    case 'int_l':
                        $result .= $this->WriteInt32LE($data[$key]);
                        break;
                    case 'long':
                    case 'int64':
                        $result .= $this->WriteInt64($data[$key]);
                        break;
                    case 'string':
                        $result .= $this->WriteString($data[$key]);
                        break;
                    case 'octets':
                        $result .= $this->WriteOctet($data[$key]);
                        break;
                    case 'short_octets':
                        $result .= $this->WriteShortOctet($data[$key]);
                        break;
                    case 'float':
                        $result .= $this->WriteFloat($data[$key]);
                        break;
                    case 'float_nr':
                        $result .= $this->WriteFloat($data[$key], false);
                        break;
                    case 'vector':
                        $this->vector = true;
                        break;
                }
            }
        }
        return $result;
    }
}