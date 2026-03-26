<?php
/**
 * LeaderboardsController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class LeaderboardsController extends CController
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
    public function rolesAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $criteria = CConfig::get('leaderboards.roles.criteria');
        $bad = CConfig::get('leaderboards.roles.bad');

        $this->view->pageSize = 25;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $limit = (($this->view->currentPage - 1) * $this->view->pageSize).','.$this->view->pageSize;

        $cache = CCache::getContent(md5('leaderboards'.$criteria.$limit).'.cch', 120);
        if(!$cache){
            $result = My::app()->getCurl()->run(CConfig::get('apiUrl').'leaderboard/roles', array(
                'criteria'=>$criteria,
                'limit'=>$limit,
                'bad'=>$bad
            ))->getData(true);

            if(isset($result['total']) and $result['total'] > 0 and !empty($roles)){
                CCache::setContent($result);
            }
        }else{
            $result = $cache;
        }

        $this->view->targetPath = 'leaderboards/roles';
        $this->view->totalRecords = $result['total'];
        $this->view->roles = $result['roles'];
        $this->view->render('leaderboards/roles', $request->isAjaxRequest());
    }
}