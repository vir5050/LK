<?php
/**
 * SkillsController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class SkillsController extends CController
{
    /** @var mixed */
    protected $apiUrl;

    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();

        CAuth::handleLogin('user/login');

        $this->view->actionMessage = '';
        $this->apiUrl = CConfig::get('apiUrl');
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Skills $model */
        $model = Skills::model();

        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'skills'));
        if($service->enable == 1){
            $type = $request->getQuery('type', 'string', 'common');
            if(!CValidator::inArray($type, array('common', 'heaven', 'hell'))){
                $type = 'common';
            }

            $this->view->targetPath = 'skills/index'.(!empty($type) ? '/type/'.$type : '');
            $this->view->pageSize = 20;
            $this->view->currentPage = $request->getQuery('page', 'integer', 1);
            $this->view->totalRecords = $model->countByAttributes(array('for_sale'=>1, 'type'=>$type));
            $this->view->skills = $model->findAll(array(
                    'condition'=>'for_sale = :for_sale AND type = :type',
                    'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize,
                    'order'=>'id ASC'),
                array(':for_sale'=>1, ':type'=>$type)
            );
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if($request->getPost('act') == 'buy' and $service->enable == 1){
            if(APP_MODE == 'demo'){
                $msg = My::t('core', 'Blocked in Demo Mode.');
                $messageType = 'warning';
            }else{
                $skillId = $request->getPost('skillId');
                if(CValidator::isInteger($skillId)){
                    $skill = $model->findByAttributes(array('id'=>$skillId, 'for_sale'=>1));
                    if($skill===null){
                        $msg = My::t('app', 'Failed');
                        $messageType = 'warning';
                    }else{
                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        $roleId = CAuth::getLoggedParam('selectedRoleId');
                        if($roleId===null){
                            $msg = My::t('app', 'Character not selected');
                            $messageType = 'error';
                        }elseif($skill->price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $result = $curl->run($this->apiUrl.'role/get', array(
                                'roleid' => $roleId,
                                'part' => 'status'
                            ))->getData(true);

                            if($result['status'] == 1){
                                $role = $result['data']['role'];
                                COctet::prepareRead($role['status']['skills']);
                                $skills = COctet::binaryRead(array('count'=>'int_l'));
                                for($i = 0; $i < $skills['count']; $i++){
                                    $skills['skills'][$i] = COctet::binaryRead(array('id'=>'int_l', 'progress'=>'int_l', 'level'=>'int_l'));
                                }

                                foreach($skills['skills'] as $value){
                                    if($value['id'] == $skill->id){
                                        $learned = 1;
                                    }
                                }

                                if(isset($learned)){
                                    $msg = My::t('app', 'Skill already learned');
                                    $messageType = 'error';
                                }else{
                                    $skills['skills'][$skills['count']+1]['id'] = $skill->id;
                                    $skills['skills'][$skills['count']+1]['progress'] = $skill->progress;
                                    $skills['skills'][$skills['count']+1]['level'] = $skill->level;

                                    $newSkills = COctet::binaryWrite(array('count'=>$skills['count']+1), array('count'=>'int_l'));
                                    foreach($skills['skills'] as $value){
                                        $newSkills .= COctet::binaryWrite($value, array('id'=>'int_l', 'progress'=>'int_l', 'level'=>'int_l'));
                                    }

                                    $role['status']['skills'] = bin2hex($newSkills);
                                    $result = $curl->run($this->apiUrl.'role/put', array(
                                        'roleid'=>$roleId,
                                        'value'=>json_encode($role),
                                        'part'=>'status'
                                    ))->getData(true);

                                    if($result['status']==1){
                                        $log = new ServiceLog;
                                        $log->account_id = CAuth::getLoggedId();
                                        $log->service_id = My::t('app', 'Learning skills').' ('.$skill->name.')';
                                        $log->ip_address = CIp::getBinaryIp();
                                        $log->request_date = time();
                                        $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$skill->price));
                                        $log->save();

                                        $user->coins = $user->coins - $skill->price;
                                        $user->save();

                                        $msg = My::t('app', 'Successfully');
                                        $messageType = 'success';
                                    }else{
                                        $msg = My::t('app', 'Failed');
                                        $messageType = 'warning';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->type = isset($type) ? $type : 'common';
        $this->view->setMetaTags('title', My::t('app', 'Learning skills'));
        $this->view->render('skills/index', $request->isAjaxRequest());
    }

    /**
     * Skills admin action handler
     */
    public function adminAction()
    {
        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('index/index');
        }

        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Skills $model */
        $model = Skills::model();

        /*if($request->getPost('act') == 'skill_remove'){
            $skillId = $request->getPost('sid');
            if($model->deleteByPk($skillId)){
                echo My::t('app', 'Successfully');
            }
            exit;
        }*/

        $filterId = $request->getQuery('filterId');
        $filterName = $request->getQuery('filterName');
        if($filterId != ''){
            $condition = 'id = :id';
            $params = array(':id'=>$filterId);
        }elseif($filterName != ''){
            $condition = 'name like :name';
            $params = array(':name'=>'%'.$filterName.'%');
        }else{
            $condition = '';
            $params = array();
        }

        $this->view->targetPath = 'skills/admin'.($filterName != '' ? '/filterName/'.$filterName : '');
        $this->view->pageSize = 20;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $model->count($condition, $params);
        $this->view->skills = $model->findAll(array('condition'=>$condition, 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'for_sale DESC, id ASC'), $params);

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Learning skills'));
        $this->view->render('skills/admin', $request->isAjaxRequest());
    }

    /**
     * Skills edit action handler
     */
    public function editAction()
    {
        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('index/index');
        }

        /** @var Skills $model */
        $model = Skills::model();
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        if($request->getPost('act') == 'save'){
            $skillId = $request->getPost('id');
            $item = $model->findByPk($skillId);
            $item->name = $request->getPost('name');
            $item->icon = $request->getPost('icon');
            $item->price = $request->getPost('price');
            $item->level = $request->getPost('level');
            $item->progress = $request->getPost('progress');
            $item->type = $request->getPost('type');
            $item->for_sale = ($request->getPost('for_sale') !== '') ? $request->getPost('for_sale') : 0;
            $item->save();
        }

        $id = $request->getQuery('id');
        if(!empty($id)){
            $result = $model->findByPk($id);
            if($result!==null){
                $this->view->skill = $model->getFieldsAsArray();
            }
        }

        $this->view->render('skills/edit', $request->isAjaxRequest());
    }
}