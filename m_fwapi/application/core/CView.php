<?php
/**
 * CView base class file
 *
 * PUBLIC:					PROTECTED:					PRIVATE:
 * ----------			   ----------				  ----------
 * __construct
 * __set
 * __get
 * renderJson
 * setController
 * getController
 * setAction
 * getAction
 *
 * STATIC:
 * ---------------------------------------------------------------
 *
 */

class CView
{
    /** @var string */
    private $_controller;
    /** @var string */
    private $_action;
    /** @var array */
    private $_vars = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
    }

    /**
     * Setter method
     * @param string $index
     * @param mixed $value
     * @return void
     */
    public function __set($index, $value)
    {
        $this->_vars[$index] = $value;
    }

    /**
     * Getter method
     * @param string $index
     * @return string
     */
    public function __get($index)
    {
        return isset($this->_vars[$index]) ? $this->_vars[$index] : '';
    }

    /**
     * Render a json response
     * @param array $data
     * @return void
     */
    public function renderJson(array $data = [])
    {
        header('HTTP/1.1 200 OK');
        header('Content-type: application/json; charset=utf-8');

        echo json_encode($data, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Controller setter
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->_controller = $controller;
    }

    /**
     * Controller getter
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Action setter
     * @param string $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /**
     * Action getter
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }
}