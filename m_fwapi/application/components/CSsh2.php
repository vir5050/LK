<?php

/**
 * Class CSsh2
 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------               ----------                  ----------
 * __construct              connect
 * exec                     authByPassword
 *
 * STATIC:
 * ---------------------------------------------------------------
 * init
 *
 */
class CSsh2 extends CComponent
{
    /** @var resource */
    protected $session = null;
    /** @var string */
    protected $host;
    /** @var string */
    protected $port;
    /** @var string */
    protected $username;
    /** @var string */
    protected $password;

    /** @var string */
    private $connectionType;

    /**
     * Class default constructor
     */
    function __construct()
    {
        if(CConfig::get('ssh.enable')){
            $this->host = CConfig::get('ssh.host', 'root');
            $this->port = CConfig::get('ssh.port', 22);
            $this->username = CConfig::get('ssh.username', 'root');
            $this->password = CConfig::get('ssh.password');
            $this->connectionType = CConfig::get('ssh.connectionType', 'password');

            $this->connect();
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
     * Connect to an SSH server
     */
    protected function connect()
    {
        if(!function_exists('ssh2_connect')){
            exit('SSH2 not supported.');
        }

        $this->session = ssh2_connect($this->host, $this->port);

        switch($this->connectionType){
            case 'password':
                $this->authPassword($this->username, $this->password);
                break;
            case 'public_key':
                // todo
                break;
            default:
                break;
        }
    }

    /**
     * Authenticate over SSH using a plain password
     * @param $username
     * @param $password
     */
    protected function authPassword($username, $password)
    {
        @ssh2_auth_password($this->session, $username, $password);
    }

    /**
     * Execute a command on a remote server
     * @param $cmd
     * @param null $pty
     * @param array $env
     * @param int $width
     * @param int $height
     * @param int $width_height_type
     * @return string
     */
    public function exec($cmd, $pty = null, array $env = [], $width = 80, $height = 25, $width_height_type = SSH2_TERM_UNIT_CHARS)
    {
        if($this->session===null){
            exit('SSH2 not supported.');
        }

        $stdout = ssh2_exec($this->session, $cmd, $pty, $env, $width, $height, $width_height_type);
        $stderr = ssh2_fetch_stream($stdout, SSH2_STREAM_STDERR);

        stream_set_blocking($stderr, true);
        stream_set_blocking($stdout, true);

        $error = stream_get_contents($stderr);
        if($error!==''){
            exit($error);
        }

        return stream_get_contents($stdout);
    }

    /**
     * Class default destructor
     */
    function __destruct()
    {
        unset($this->session);
    }
}