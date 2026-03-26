<?php

/**
 * CRouter core class file
 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------			   ----------				  ----------
 * __construct
 * route
 * getCurrentUrl
 *
 *
 * STATIC:
 * ---------------------------------------------------------------
 * getParams
 *
 */
class CRouter
{
    /**	@var string */
    private $_path;
    /**	@var string */
    private $_controller;
    /**	@var string */
    private $_action;
    /** @var array */
    private static $_params = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
        $urlFormat = CConfig::get('urlManager.urlFormat');
        $rules = (array)CConfig::get('urlManager.rules');

        $request = isset($_GET['url']) ? $_GET['url'] : '';
        $standardCheck = true;
        if($urlFormat == 'shortPath' && is_array($rules)){
            foreach($rules as $rule => $val){
                $matches = '';
                if(preg_match_all('{'.$rule.'}i', $request, $matches)){
                    if(isset($matches[1]) && is_array($matches[1])){
                        foreach($matches[1] as $mkey => $mval){
                            $val = str_ireplace('{$'.$mkey.'}', $mval, $val);
                        }
                        $request = $val;
                        break;
                    }
                }
            }
        }

        if($standardCheck){
            $split = explode('/', trim($request, '/'));
            if($split){
                foreach($split as $index => $part){
                    if(!$this->_controller){
                        $this->_controller = ucfirst($part);
                    }else if(!$this->_action){
                        $this->_action = $part;
                    }else{
                        if(!self::$_params || end(self::$_params) !== null){
                            self::$_params[$part] = null;
                        }else{
                            $arrayArg = array_keys(self::$_params);
                            self::$_params[end($arrayArg)] = $part;
                        }
                    }
                }
            }
        }
        if(!$this->_controller){
            $defaultController = CConfig::get('defaultController');
            $this->_controller = !empty($defaultController) ? CFilter::sanitize('alphanumeric', $defaultController) : 'Index';
        }
        if(!$this->_action){
            $defaultAction = CConfig::get('defaultAction');
            $this->_action = !empty($defaultAction) ? CFilter::sanitize('alphanumeric', $defaultAction) : 'index';
        }
    }

    /**
     * Router
     */
    public function route()
    {
        $appDir = APP_PATH.DS.'protected'.DS.'controllers'.DS;
        $file = $this->_controller.'Controller.php';

        if(is_file($appDir.$file)){
            $class = $this->_controller.'Controller';
        }else{
            $class = 'ErrorController';
            My::app()->setResponseCode('404');
        }
        My::app()->view->setController($this->_controller);
        $controller = new $class();

        if(is_callable([$controller, $this->_action.'Action'])){
            $action = $this->_action.'Action';
        }else if($class != 'ErrorController'){
            $reflector = new ReflectionMethod($class, 'errorAction');
            if($reflector->getDeclaringClass()->getName() == 'CController'){
                $controller = new ErrorController();
                $action = 'indexAction';
            }else{
                $action = 'errorAction';
            }
        }else{
            $action = 'indexAction';
        }

        My::app()->view->setAction($this->_action);

        call_user_func_array([$controller, $action], self::getParams());
    }

    /**
     * Returns current URL
     * @return string
     */
    public function getCurrentUrl()
    {
        $path = My::app()->getRequest()->getBaseUrl();
        $path .= strtolower(My::app()->view->getController()).'/';
        $path .= My::app()->view->getAction();

        $params = self::getParams();
        foreach($params as $key => $val){
            $path .= '/'.$key.'/'.$val;
        }

        return $path;
    }

    /**
     * Get array of parameters
     * @return array
     */
    public static function getParams()
    {
        return self::$_params;
    }
}