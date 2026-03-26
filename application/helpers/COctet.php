<?php
/**
 * COctet provides work with octets
 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------               ----------                  ----------
 * __construct
 * convertHexToBinary
 * binaryRead
 * binaryWrite
 * readItemoctet
 * packItemdata
 */

class COctet
{
    /** @var bool */
    public static $vector = false;
    /** @var string */
    public static $_binary = '';
    /** @var int */
    public static $_position = 0;
    /** @var array */
    public static $_extend_prop = [];
    /** @var array */
    public static $_item_preq = [];
    /** @var array */
    public static $_armor_essence = [];
    /** @var array */
    public static $_weapon_essence = [];
    /** @var array */
    public static $_classTemplate = [];
	/** @var array */
    public static $reborn = ['unk'=>'short_l', 'level'=>'short_l'];

    /**
     * Class default constructor
     */
    function __construct()
    {
    }

    /**
     * @param string $octet
     */
    public static function prepareRead($octet)
    {
        if(!empty($octet)){
            self::$_binary = pack('H*', $octet);
            self::$_position = 0;
        }
    }

    /**
     * @param $cls
     * @param $level
     * @param $property
     * @return string
     */
    public static function reborn($data)
    {
        self::prepareRead($data);
        return self::binaryRead(self::$reborn);
    }

    /**
     * @param $structure
     * @return array
     */
    public static function binaryRead($structure)
    {
        self::$vector = false;
        $_data = array();
        foreach($structure as $key => $value){
            if(is_array($value)){
                if(self::$vector){
                    $count = self::ReadCUInt(self::$_binary);
                    $_data['count'] = $count;
                    for($i = 0; $i < $count; $i++){
                        $_data[$key][$i] = self::binaryRead($value);
                    }
                    self::$vector = false;
                }else{
                    $_data[$key] = self::binaryRead($value);
                }
            }else{
                switch($value){
                    case 'int':
                        $_data[$key] = self::ReadInt32(self::$_binary);
                        break;
                    case 'int_l':
                        $_data[$key] = self::ReadInt32LE(self::$_binary);
                        break;
                    case 'byte':
                        $_data[$key] = self::ReadByte(self::$_binary);
                        break;
                    case 'octets':
                        $_data[$key] = self::ReadOctet(self::$_binary);
                        break;
                    case 'name':
                        $_data[$key] = self::ReadString(self::$_binary);
                        break;
                    case 'short':
                        $_data[$key] = self::ReadInt16(self::$_binary);
                        break;
                    case 'short_l':
                        $_data[$key] = self::ReadInt16LE(self::$_binary);
                        break;
                    case 'float':
                        $_data[$key] = self::ReadFloat(self::$_binary);
                        break;
                    case 'float_nr':
                        $_data[$key] = self::ReadFloat(self::$_binary, false);
                        break;
                    case 'cuint':
                        $_data[$key] = self::ReadCUInt(self::$_binary);
                        break;
                    case 'vector':
                        self::$vector = true;
                        break;
                }
            }
        }

        return $_data;
    }

    /**
     * @param $data
     * @param $structure
     * @return string
     */
    public static function binaryWrite($data, $structure)
    {
        $result = '';
        foreach($structure as $key => $value){
            if(is_array($value)){
                $result .= self::binaryWrite($data[$key], $value);
            }else{
                switch($value){
                    case 'int':
                        $result .= self::WriteInt32($data[$key]);
                        break;
                    case 'int_l':
                        $result .= self::WriteInt32LE($data[$key]);
                        break;
                    case 'byte':
                        $result .= self::WriteByte($data[$key]);
                        break;
                    case 'octets':
                        $result .= self::WriteOctet($data[$key]);
                        break;
                    case 'name':
                        $result .= self::WriteString($data[$key]);
                        break;
                    case 'short':
                        $result .= self::WriteInt16($data[$key]);
                        break;
                    case 'short_l':
                        $result .= self::WriteInt16LE($data[$key]);
                        break;
                    case 'float':
                        $result .= self::WriteFloat($data[$key]);
                        break;
                    case 'float_nr':
                        $result .= self::WriteFloat($data[$key], false);
                        break;
                }
            }
        }

        return $result;
    }

    /**
     * @param $data
     * @return int
     */
    protected function ReadCUInt($data)
    {
        list($byte) = array_values(unpack('C', substr($data, self::$_position)));
        switch($byte & 0xE0){
            case 224:
                self::$_position++;
                list($byte) = array_values(unpack('N', substr($data, self::$_position)));
                self::$_position += 4;
                return $byte;
            case 192:
                list($byte) = array_values(unpack('N', substr($data, self::$_position)));
                self::$_position += 4;
                return $byte & 0x3FFFFFFF;
            case 128:
            case 160:
                list($byte) = array_values(unpack('n', substr($data, self::$_position)));
                self::$_position += 2;
                return $byte & 0x7FFF;
        }

        self::$_position++;
        return $byte;
    }

    /**
     * @param $data
     * @return string
     */
    protected static function ReadString($data)
    {
        $size = self::ReadCUInt($data);
        $result = mb_convert_encoding(substr($data, self::$_position, $size), "UTF-8","UTF-16LE");
        self::$_position += $size;
        return $result;
    }

    /**
     * @param $data
     * @return string
     */
    protected static function ReadOctet($data)
    {
        $size = self::ReadCUInt($data);
        $result = bin2hex(substr($data, self::$_position, $size));
        self::$_position += $size;
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected static function ReadByte($data)
    {
        list($result) = array_values(unpack('C', substr($data, self::$_position)));
        self::$_position++;

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected static function ReadInt16($data)
    {
        list($result) = array_values(unpack('n', substr($data, self::$_position)));
        self::$_position += 2;
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected static function ReadInt16LE($data)
    {
        list($result) = array_values(unpack('v', substr($data, self::$_position)));
        self::$_position += 2;
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected static function ReadInt32($data)
    {
        list($result) = array_values(unpack('N', substr($data, self::$_position)));
        self::$_position += 4;
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected static function ReadInt32LE($data)
    {
        list($result) = array_values(unpack('V', substr($data, self::$_position)));
        self::$_position += 4;
        return $result;
    }

    /**
     * @param $data
     * @param boolean $reverse
     * @return mixed
     */
    protected static function ReadFloat($data, $reverse = true)
    {
        list($result) = array_values(unpack("f", ($reverse===true) ? strrev(substr($data, self::$_position, 4)) : substr($data, self::$_position, 4)));
        self::$_position += 4;
        return $result;
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteByte($data)
    {
        return pack('C', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteInt16($data)
    {
        return pack('n', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteInt16LE($data)
    {
        return pack('v', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteInt32($data)
    {
        return pack('N', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteInt32LE($data)
    {
        return pack('V', $data);
    }

    /**
     * @param $data
     * @param boolean $reverse
     * @return string
     */
    protected static function WriteFloat($data, $reverse = true)
    {
        return ($reverse===true) ? strrev(pack('f', $data)) : pack('f', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteCUInt($data)
    {
        if($data < 128)
            return pack('C', $data);
        else if($data < 16384)
            return pack('n', ($data | 0x8000));
        else if($data < 536870912)
            return pack('N', ($data | 0xC0000000));
        return pack('C', 224) . pack('N', $data);
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteString($data)
    {
        $data = iconv("UTF-8", "UTF-16LE", $data);
        return self::WriteCUInt(strlen($data)).$data;
    }

    /**
     * @param $data
     * @return string
     */
    protected static function WriteOctet($data)
    {
        $data = pack('H*', $data);
        return self::WriteCUInt(strlen($data)).$data;
    }
}