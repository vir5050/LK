<?php
/**
 * ChatController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class ChatController extends CController
{
    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();

        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('index/index');
        }

        CAuth::handleLogin('user/login');
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
		
		$cache = null;//CCache::getContent('livechat.cch', 1);
		if(!$cache){
			$chat = My::app()->getCurl()->run(CConfig::get('apiUrl').'chat/')->getData(true);
			//CCache::setContent($chat);
		} else {
			$chat = $cache;
		}
		
        if(!empty($chat)){
			$this->view->chat = array_reverse($chat);
			$this->view->lifetime = time() - CCache::getFileLifetime();
        }
        $this->view->setMetaTags('title', My::t('app', 'Ировой чат в реальном времени'));
        $this->view->render('chat/index', $request->isAjaxRequest());
    }

    /**
     * Chat ajax action handler
     */
    public function ajaxAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $cache = null;//CCache::getContent('livechat.cch', 1);
		if(!$cache){
			$chat = My::app()->getCurl()->run(CConfig::get('apiUrl').'chat/')->getData(true);
			//CCache::setContent($chat);
		} else {
			$chat = $cache;
		}

        if(!empty($chat)){
			$this->view->chat = array_reverse($chat);
        }
        $this->view->render('chat/ajax', true);
    }
}