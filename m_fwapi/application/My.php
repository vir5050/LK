<?php
/**
 * MyWeb bootstrap file
 *
 * PUBLIC:					PROTECTED:					    PRIVATE:
 * ----------               ----------                      ----------
 * __construct              _onBeginRequest                 _autoload
 * run                      _registerCoreComponents
 * getComponent             _setComponent
 * getRequest               _hasEvent
 * attachEventHandler       _hasEventHandler
 * detachEventHandler       _raiseEvent
 * getCurl
 * setResponseCode
 * getResponseCode
  *
 * STATIC:
 * ---------------------------------------------------------------
 * init
 * app
 * powered
 * getVersion
 * t
 *
 */

class My
{
    /**	@var CView $view */
    public $view;
    /**	@var CRouter $router */
    public $router;

    /** @var object */
    private static $_instance;
    /** @var array */
    private static $_classMap = [
        'Controller'    => 'controllers',
        'Model'         => 'models',
        ''              => 'models',
    ];
    /** @var array */
    private static $_coreClasses = [
        'CComponent'   => 'components/CComponent.php',
        'CConfig'      => 'components/CConfig.php',
        'CHttpRequest' => 'components/CHttpRequest.php',
        'CProtocol'    => 'components/CProtocol.php',
        'CSsh2'        => 'components/CSsh2.php',

        'CController' => 'core/CController.php',
        'CModel'      => 'core/CModel.php',
        'CRouter'     => 'core/CRouter.php',
        'CView'       => 'core/CView.php',

        'CActiveRecord' => 'db/CActiveRecord.php',
        'CDatabase'     => 'db/CDatabase.php',

        'CFilter' => 'helpers/CFilter.php',
        'CHash'   => 'helpers/CHash.php',

        'BinaryRead'  => 'traits/BinaryRead.php',
        'BinaryWrite' => 'traits/BinaryWrite.php',
    ];
    /** @var array */
    private static $_coreComponents = [
        'request'  => ['class' => 'CHttpRequest'],
        'protocol' => ['class' => 'CProtocol'],
        'ssh2'     => ['class' => 'CSsh2'],
    ];
    /** @var array */
    private static $_appClasses = [];
    /** @var array */
    private $_components = [];
    /** @var array */
    private $_events;
    /** @var string */
    private $_responseCode = '';

    /**
     * Class constructor
     * @param array $configDir
     */
    public function __construct($configDir)
    {
        spl_autoload_register([$this, '_autoload']);

        $configMain = $configDir.'main.php';
        $configDb = $configDir.'db.php';

        if(is_string($configMain) && is_string($configDb)){
            if(!file_exists($configMain)){
                exit('File \''.$configMain.'\' not found.');
            }else{
                $arrConfig = require($configMain);
                if(file_exists($configDb)){
                    $arrDbConfig = require($configDb);
                    $arrConfig = array_merge($arrConfig, $arrDbConfig);
                }else{
                    exit('File \''.$configDb.'\' not found.');
                }
            }
            /* save config */
            CConfig::load($arrConfig);
        }
    }

    /**
     * Runs application
     */
    public function run()
    {
        if(APP_MODE != 'off'){
            if(APP_MODE == 'debug' || APP_MODE == 'test'){
                error_reporting(E_ALL);
                ini_set('display_errors', 'On');
            }else{
                error_reporting(E_ALL);
                ini_set('display_errors', 'Off');
                ini_set('log_errors', 'On');
                ini_set('error_log', APP_PATH.DS.'protected'.DS.'tmp'.DS.'logs'.DS.'error.log');
            }

            $this->view = new CView();
        }

        $this->_registerCoreComponents();

        if($this->_hasEventHandler('_onBeginRequest')) $this->_onBeginRequest();

        if(APP_MODE != 'off'){
            $this->router = new CRouter();
            $this->router->route();
        }
    }

    /**
     * Class init constructor
     * @param array $config
     * @return My
     */
    public static function init($config = [])
    {
        if(self::$_instance == null) self::$_instance = new self($config);
        return self::$_instance;
    }

    /**
     * Returns A object
     * @internal param array $config
     * @return My
     */
    public static function app()
    {
        return self::$_instance;
    }

    /**
     * Autoloader
     * @param string $className
     * @return void
     */
    private function _autoload($className)
    {
        if(isset(self::$_coreClasses[$className])){
            include(dirname(__FILE__).DS.self::$_coreClasses[$className]);
        }else if(isset(self::$_appClasses[$className])){
            include(APP_PATH.DS.'protected'.DS.self::$_appClasses[$className]);
        }else{
            $classNameItems = preg_split('/(?=[A-Z])/', $className);
            $itemsCount = count($classNameItems);
            $pureClassName = $pureClassType = '';
            for($i = 0; $i < $itemsCount; $i++){
                if($i < $itemsCount-1){
                    $pureClassName .= isset($classNameItems[$i]) ? $classNameItems[$i] : '';
                }else{
                    $pureClassType = isset($classNameItems[$i]) ? $classNameItems[$i] : '';
                }
            }

            if(isset(self::$_classMap[$pureClassType])){
                $classCoreDir = APP_PATH.DS.'protected'.DS.self::$_classMap[$pureClassType];
                $classFile = $classCoreDir.DS.$className.'.php';
                if(is_file($classFile)){
                    include($classFile);
                }else{
                    exit('Can\'t include file \''.$classFile.'\'');
                }
            }else{
                $pureClassType = 'Model';
                $classCoreDir = APP_PATH.DS.'protected'.DS.self::$_classMap[$pureClassType];
                $classFile = $classCoreDir.DS.$className.'.php';
                if(is_file($classFile)){
                    include($classFile);
                }else{
                    exit('Can\'t include file \''.$classFile.'\'');
                }
            }
        }
    }

    /**
     * Puts a component under the management of the application
     * @param string $id
     * @param CComponent $component
     */
    protected function _setComponent($id, $component)
    {
        if($component===null){
            unset($this->_components[$id]);
        }else{
            if(@$callback = $component::init()){
                $this->_components[$id] = $callback;
            }
        }
    }

    /**
     * Returns the application component
     * @param string $id
     * @return null
     */
    public function getComponent($id)
    {
        return (isset($this->_components[$id])) ? $this->_components[$id] : null;
    }

    /**
     * Returns the request component
     * @return CHttpRequest component
     */
    public function getRequest()
    {
        return $this->getComponent('request');
    }

    /**
     * Returns the protocol component
     * @return CProtocol component
     */
    public function getProtocol()
    {
        return $this->getComponent('protocol');
    }

    /**
     * Returns the ssh2 component
     * @return CSsh2 component
     */
    public function getSSH()
    {
        return $this->getComponent('ssh2');
    }

    /**
     * Attaches event handler
     * @param string $name
     * @param string $handler
     */
    public function attachEventHandler($name, $handler)
    {
        if($this->_hasEvent($name)){
            $name = strtolower($name);
            if(!isset($this->_events[$name])){
                $this->_events[$name] = [];
            }
            if(!in_array($handler, $this->_events[$name])){
                $this->_events[$name][] = $handler;
            }
        }
    }

    /**
     * Detaches event handler
     * @param string $name
     */
    public function detachEventHandler($name)
    {
        if($this->_hasEvent($name)){
            $name = strtolower($name);
            if(isset($this->_events[$name])){
                unset($this->_events[$name]);
            }
        }
    }

    /**
     * Checks whether an event is defined
     * An event is defined if the class has a method named like 'onSomeMethod'
     * @param string $name
     * @return boolean
     */
    protected function _hasEvent($name)
    {
        return !strncasecmp($name, '_on', 3) && method_exists($this, $name);
    }

    /**
     * Checks whether the named event has attached handlers
     * @param string $name
     * @return boolean
     */
    public function _hasEventHandler($name)
    {
        $name = strtolower($name);
        return isset($this->_events[$name]) && count($this->_events[$name]) > 0;
    }

    /**
     * Raises an event
     * @param string $name
     */
    public function _raiseEvent($name)
    {
        $name = strtolower($name);
        if(isset($this->_events[$name])){
            foreach($this->_events[$name] as $handler){
                if(is_string($handler[1])){
                    call_user_func_array([$handler[0], $handler[1]], []);
                }
            }
        }
    }

    /**
     * Sets response code
     * @param string $code
     */
    public function setResponseCode($code = '')
    {
        $this->_responseCode = $code;
    }

    /**
     * Get response code
     */
    public function getResponseCode()
    {
        return $this->_responseCode;
    }

    /**
     * Raised before the application processes the request
     */
    protected function _onBeginRequest()
    {
        $this->_raiseEvent('_onBeginRequest');
    }

    /**
     * Registers core components
     */
    protected function _registerCoreComponents()
    {
        foreach(self::$_coreComponents as $id => $component){
            $this->_setComponent($id, $component['class']);
        }
    }
}