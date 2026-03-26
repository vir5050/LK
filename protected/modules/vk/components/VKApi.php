<?php

class VKApi extends CComponent
{
    const API_VERSION = '5.27';
    const AUTHORIZE_URL = 'https://oauth.vk.com/authorize?client_id={client_id}&scope={scope}&redirect_uri={redirect_uri}&display={display}&v=5.24&response_type={response_type}';
    const GET_TOKEN_URL = 'https://oauth.vk.com/access_token?client_id={client_id}&client_secret={client_secret}&code={code}&redirect_uri={redirect_uri}';
    const METHOD_URL = 'https://api.vk.com/method/';

    /** @var null */
    public $secret_key = null;
    /** @var array */
    public $scope = array();
    /** @var null */
    public $client_id = null;
    /** @var null */
    public $access_token = null;
    /** @var int */
    public $owner_id = 0;
    /** @var string */
    public $callback_url = '';

    /**
     * Class constructor
     * @return VKApi
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public static function init()
    {
        return parent::init(__CLASS__);
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options = array())
    {
        $this->scope[]='offline';
        $this->callback_url = My::app()->app()->getRequest()->getBaseUrl().'vk/repost';

        if(count($options) > 0){
            foreach($options as $key => $value){
                if($key == 'scope' and is_string($value)){
                    $_scope = explode(',', $value);
                    $this->scope = array_merge($this->scope, $_scope);
                }else{
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * @param string $method (http://vk.com/dev/methods)
     * @param array $vars
     * @return array
     */
    public function api($method = '', $vars = array())
    {
        $vars['v'] = self::API_VERSION;

        $params = http_build_query($vars);
        $url = $this->httpBuildQuery($method, $params);
        return $this->call($url);
    }

    /**
     * @param $method
     * @param string $params
     * @return string
     */
    private function httpBuildQuery($method, $params = '')
    {
        return  self::METHOD_URL.$method.'?'.$params.'&access_token='.$this->access_token;
    }

    /**
     * @param string $type
     * @param string $display
     * @return mixed
     */
    public function getAuthorizeUrl($type = 'code', $display = 'page')
    {
        $url = strtr(self::AUTHORIZE_URL, array(
            '{client_id}'=>$this->client_id,
            '{scope}'=>implode(',', $this->scope),
            '{redirect_uri}'=>$this->callback_url,
            '{display}'=>$display,
            '{response_type}'=>$type
        ));

        return $url;
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getToken($code)
    {
        $url = strtr(self::GET_TOKEN_URL, array(
            '{code}'=>$code,
            '{client_id}'=>$this->client_id,
            '{client_secret}'=>$this->secret_key,
            '{redirect_uri}'=>$this->callback_url
        ));

        return $this->call($url);
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function call($url)
    {
        $json = json_decode(file_get_contents($url), true);
        if(isset($json['response']))
            return $json['response'];

        return $json;
    }
}