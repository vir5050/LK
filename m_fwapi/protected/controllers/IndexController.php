<?php
/**
 * IndexController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */
class IndexController extends CController
{
    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        echo 'MyWeb Server API';
    }
}