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
class FaqController extends CController
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

        $this->view->render('faq/index', $request->isAjaxRequest());
    }
}