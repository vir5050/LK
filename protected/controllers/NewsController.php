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

class NewsController extends CController
{
    /** @var mixed */
    protected $apiUrl;

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Post $model */
        $model = Post::model();

        $this->view->targetPath = 'news/index';
        $this->view->pageSize = 3;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $model->count();
        $this->view->posts = $model->findAll(array('limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'post_date DESC'));
        
        $this->view->setMetaTags('title', My::t('app', 'Activity Log'));
        $this->view->render('news/index', $request->isAjaxRequest());
    }

    /**
     * Exchange cubigold action handler
     */
    public function fullAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $this->view->render('news/full', $request->isAjaxRequest());
    }
}