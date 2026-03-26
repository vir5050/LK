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
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Post $model */
        $model = Post::model();

        $this->view->targetPath = 'index/index';
        $this->view->pageSize = 3;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $model->count();
        $this->view->posts = $model->findAll(array('limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'post_date DESC'));

        $this->view->render('index/index', $request->isAjaxRequest());
    }
}