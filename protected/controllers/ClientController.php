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
class ClientController extends CController
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
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Post $model */
        $model = Post::model();

        $this->view->targetPath = 'index/index';

        $this->view->render('client/index', $request->isAjaxRequest());
    }
}