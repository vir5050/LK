<?php
/**
 * ExchangeController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class AllnewsController extends CController
{
    /** @var mixed */
    protected $apiUrl;

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        $this->redirect('index/index');
    }

    /**
     * Exchange cubigold action handler
     */
    public function fullAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $this->view->render('news/index', $request->isAjaxRequest());
    }
}