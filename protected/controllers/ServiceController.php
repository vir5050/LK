<?php
/**
 * ServiceController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class ServiceController extends CController
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

        $this->view->errorField = '';
        $this->view->actionMessage = '';

        $this->apiUrl = CConfig::get('apiUrl');
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        $this->redirect('index/index');
    }

    /**
     * Service levelboost action handler
     */
    public function levelboostAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'levelboost'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        'count'=>array('title'=>My::t('app', 'Count'), 'validation'=>array('required'=>true, 'type'=>'integer', 'minLength'=>1, 'maxLength'=>3))
                    )
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    $user = User::model()->findByPk(CAuth::getLoggedId());
                    $count = $request->getPost('count', 'integer', 0);
                    $roleId = CAuth::getLoggedParam('selectedRoleId');
                    if($roleId===null){
                        $msg = My::t('app', 'Character not selected');
                        $messageType = 'error';
                    }elseif($count < $service->min){
                        $msg = My::t('core', 'The field {title} must be greater than or equal to {min}!', array('{title}'=>My::t('app', 'Count'), '{min}'=>$service->min));
                        $messageType = 'error';
                    }else{
                        $price = round($count * $service->price);
                        if($price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $curl->run($this->apiUrl.'role/get', array(
                                'roleid'=>$roleId,
                                'part'=>'status'
                            ));

                            $result = $curl->getData(true);
                            if($result['status']==1){
                                $role = $result['data']['role'];
                                $newLevel = $role['status']['level']+$count;
                                if($newLevel > $service->max){
                                    $msg = My::t('app', 'Max. level - {max}', array('{max}'=>$service->max));
                                    $messageType = 'error';
                                }else{
                                    $role['status']['level'] = $newLevel;
                                    $role['status']['pp'] += $count * 5;
                                    $role['status']['occupation'] = COctet::calculateProperty(CAuth::getLoggedParam('selectedRoleCls'), $role['status']['level'], $role['status']['occupation']);

                                    $curl->run($this->apiUrl.'role/put', array(
                                        'roleid'=>$roleId,
                                        'value'=>json_encode($role),
                                        'part'=>'status'
                                    ));

                                    $result = $curl->getData(true);
                                    if($result['status']==1){
                                        $log = new ServiceLog;
                                        $log->account_id = CAuth::getLoggedId();
                                        $log->service_id = My::t('app', 'Level boost');
                                        $log->ip_address = CIp::getBinaryIp();
                                        $log->request_date = time();
                                        $log->request_data = json_encode(array('roleid'=>$roleId, 'count'=>$count, 'price'=>$price));
                                        $log->save();

                                        $user->coins = $user->coins - $price;
                                        $user->save();

                                        $msg = My::t('app', 'Successfully');
                                        $messageType = 'success';
                                    }else{
                                        $msg = My::t('app', 'Failed');
                                        $messageType = 'warning';
                                    }
                                }
                            }else{
                                $msg = My::t('app', 'Failed');
                                $messageType = 'warning';
                            }
                        }
                    }
                }
            }
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->max = $service->max;
        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Level boost'));
        $this->view->render('service/levelboost', $request->isAjaxRequest());
    }

    /**
     * Service clearstorehousepassword action handler
     */
    public function clearstorehousepasswordAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'clearstorehousepasswd'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $user = User::model()->findByPk(CAuth::getLoggedId());
                $roleId = CAuth::getLoggedParam('selectedRoleId');
                $roleName = CAuth::getLoggedParam('selectedRoleName');
                if($roleId===null and $roleName===null){
                    $msg = My::t('app', 'Character not selected');
                    $messageType = 'error';
                }else{
                    $price = $service->price;
                    if($price > $user->coins){
                        $msg = My::t('app', 'Not enough coins');
                        $messageType = 'error';
                    }else{
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $curl->run($this->apiUrl.'role/clearstorehousepasswd', array(
                            'roleid'=>$roleId,
                            'rolename'=>$roleName
                        ));

                        $result = $curl->getData(true);
                        if($result['status']==1){
                            $log = new ServiceLog;
                            $log->account_id = CAuth::getLoggedId();
                            $log->service_id = My::t('app', 'Reset storehouse password');
                            $log->ip_address = CIp::getBinaryIp();
                            $log->request_date = time();
                            $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                            $log->save();

                            $user->coins = $user->coins - $price;
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
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Reset storehouse password'));
        $this->view->render('service/clearstorehousepasswd', $request->isAjaxRequest());
    }

    /**
     * Service changecultivation action handler
     */
    public function changecultivationAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'changecultivation'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $user = User::model()->findByPk(CAuth::getLoggedId());
                $roleId = CAuth::getLoggedParam('selectedRoleId');
                if($roleId===null){
                    $msg = My::t('app', 'Character not selected');
                    $messageType = 'error';
                }else{
                    $price = $service->price;
                    if($price > $user->coins){
                        $msg = My::t('app', 'Not enough coins');
                        $messageType = 'error';
                    }else{
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $curl->run($this->apiUrl.'role/get', array(
                            'roleid'=>$roleId,
                            'part'=>'status'
                        ));

                        $result = $curl->getData(true);
                        if($result['status']==1){
                            $role = $result['data']['role'];
                            if($role['status']['level2'] == 22){
                                $status = 32;
                            }elseif($role['status']['level2'] == 32){
                                $status = 22;
                            }

                            if(isset($status) and $role['status']['level2'] != $status){
                                $role['status']['level2'] = $status;
                                $curl->run($this->apiUrl.'role/put', array(
                                    'roleid'=>$roleId,
                                    'value'=>json_encode($role),
                                    'part'=>'status'
                                ));

                                $result = $curl->getData(true);
                                if($result['status']==1){
                                    $log = new ServiceLog;
                                    $log->account_id = CAuth::getLoggedId();
                                    $log->service_id = My::t('app', 'Change cultivation');
                                    $log->ip_address = CIp::getBinaryIp();
                                    $log->request_date = time();
                                    $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                                    $log->save();

                                    $user->coins = $user->coins - $price;
                                    $user->save();

                                    $msg = My::t('app', 'Successfully');
                                    $messageType = 'success';
                                }else{
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'warning';
                                }
                            }else{
                                $msg = My::t('app', 'The required level of workout is not reached.');
                                $messageType = 'error';
                            }
                        }else{
                            $msg = My::t('app', 'Failed');
                            $messageType = 'warning';
                        }
                    }
                }
            }
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Change cultivation'));
        $this->view->render('service/changecultivation', $request->isAjaxRequest());
    }

    /**
     * Service safeplaceteleport action handler
     */
    public function safeplaceteleportAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'teleport'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $user = User::model()->findByPk(CAuth::getLoggedId());
                $roleId = CAuth::getLoggedParam('selectedRoleId');
                if($roleId===null){
                    $msg = My::t('app', 'Character not selected');
                    $messageType = 'error';
                }else{
                    $price = $service->price;
                    if($price > $user->coins){
                        $msg = My::t('app', 'Not enough coins');
                        $messageType = 'error';
                    }else{
                        $value = json_decode($service->value);
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $result = $curl->run($this->apiUrl.'role/teleport', array(
                            'roleid'=>$roleId,
                            'worldtag'=>$value->{'worldtag'},
                            'pos_x'=>$value->{'x'},
                            'pos_y'=>$value->{'y'},
                            'pos_z'=>$value->{'z'},
                        ))->getData(true);

                        if($result['status']==1){
                            $log = new ServiceLog;
                            $log->account_id = CAuth::getLoggedId();
                            $log->service_id = My::t('app', 'Teleport to the safe place');
                            $log->ip_address = CIp::getBinaryIp();
                            $log->request_date = time();
                            $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                            $log->save();

                            $user->coins = $user->coins - $price;
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
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Teleport to the safe place'));
        $this->view->render('service/safeplaceteleport', $request->isAjaxRequest());
    }

    /**
     * Service resetspirit action handler
     */
    public function resetspiritAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'resetspirit'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $user = User::model()->findByPk(CAuth::getLoggedId());
                $roleId = CAuth::getLoggedParam('selectedRoleId');
                if($roleId===null){
                    $msg = My::t('app', 'Character not selected');
                    $messageType = 'error';
                }else{
                    $price = $service->price;
                    if($price > $user->coins){
                        $msg = My::t('app', 'Not enough coins');
                        $messageType = 'error';
                    }else{
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $curl->run($this->apiUrl.'role/get', array(
                            'roleid'=>$roleId,
                            'part'=>'status'
                        ));

                        $result = $curl->getData(true);
                        if($result['status']==1){
                            $role = $result['data']['role'];
                            if(isset($role['status']['sp']) and $role['status']['sp'] < 0){
                                $role['status']['sp'] = 0;
                                $curl->run($this->apiUrl.'role/put', array(
                                    'roleid'=>$roleId,
                                    'value'=>json_encode($role),
                                    'part'=>'status'
                                ));

                                $result = $curl->getData(true);
                                if($result['status']==1){
                                    $log = new ServiceLog;
                                    $log->account_id = CAuth::getLoggedId();
                                    $log->service_id = My::t('app', 'Reset spirit');
                                    $log->ip_address = CIp::getBinaryIp();
                                    $log->request_date = time();
                                    $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                                    $log->save();

                                    $user->coins = $user->coins - $price;
                                    $user->save();

                                    $msg = My::t('app', 'Successfully');
                                    $messageType = 'success';
                                }else{
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'warning';
                                }
                            }else{
                                $msg = My::t('app', 'Failed');
                                $messageType = 'warning';
                            }
                        }else{
                            $msg = My::t('app', 'Failed');
                            $messageType = 'warning';
                        }
                    }
                }
            }
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Reset spirit'));
        $this->view->render('service/resetspirit', $request->isAjaxRequest());
    }

    /**
     * Service resetexperience action handler
     */
    public function resetexperienceAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'resetexperience'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $user = User::model()->findByPk(CAuth::getLoggedId());
                $roleId = CAuth::getLoggedParam('selectedRoleId');
                if($roleId===null){
                    $msg = My::t('app', 'Character not selected');
                    $messageType = 'error';
                }else{
                    $price = $service->price;
                    if($price > $user->coins){
                        $msg = My::t('app', 'Not enough coins');
                        $messageType = 'error';
                    }else{
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $curl->run($this->apiUrl.'role/get', array(
                            'roleid'=>$roleId,
                            'part'=>'status'
                        ));

                        $result = $curl->getData(true);
                        if($result['status']==1){
                            $role = $result['data']['role'];
                            if(isset($role['status']['exp']) and $role['status']['exp'] < 0){
                                $role['status']['exp'] = 0;
                                $curl->run($this->apiUrl.'role/put', array(
                                    'roleid'=>$roleId,
                                    'value'=>json_encode($role),
                                    'part'=>'status'
                                ));

                                $result = $curl->getData(true);
                                if($result['status']==1){
                                    $log = new ServiceLog;
                                    $log->account_id = CAuth::getLoggedId();
                                    $log->service_id = My::t('app', 'Reset experience');
                                    $log->ip_address = CIp::getBinaryIp();
                                    $log->request_date = time();
                                    $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                                    $log->save();

                                    $user->coins = $user->coins - $price;
                                    $user->save();

                                    $msg = My::t('app', 'Successfully');
                                    $messageType = 'success';
                                }else{
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'warning';
                                }
                            }else{
                                $msg = My::t('app', 'Failed');
                                $messageType = 'warning';
                            }
                        }else{
                            $msg = My::t('app', 'Failed');
                            $messageType = 'warning';
                        }
                    }
                }
            }
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Reset experience'));
        $this->view->render('service/resetexperience', $request->isAjaxRequest());
    }

    /**
     * Service renamecharacter action handler
     */
    public function renamecharacterAction()
    {
       /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'renamecharacter'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo'){
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $user = User::model()->findByPk(CAuth::getLoggedId());
                    $desiredName = $request->getPost('desiredName');
                    $roleId = CAuth::getLoggedParam('selectedRoleId');
                    $roleName = CAuth::getLoggedParam('selectedRoleName');
                    if($roleId===null and $roleName===null){
                        $msg = My::t('app', 'Character not selected');
                        $messageType = 'error';
                    }elseif(!CValidator::validateLength($desiredName, $service->min, $service->max)){
                        $msg = My::t('core', 'The field {title} must be between {min} and {max}!', array('{title}'=>'Rolename', '{min}'=>$service->min, '{max}'=>$service->max));
                        $messageType = 'error';
                    }elseif(!CValidator::detectEncoding($desiredName, $service->value)){
                        $msg = My::t('core', 'Wrong name');
                        $messageType = 'error';
                    }else{
                        $price = $service->price;
                        if($price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $curl->run($this->apiUrl.'role/getid', array(
                                'rolename'=>$desiredName
                            ));

                            $result = $curl->getData(true);
                            if($result['status']==1 and $result['data']['roleid'] == -1){
                                $curl->run($this->apiUrl.'role/rename', array(
                                    'roleid'=>$roleId,
                                    'oldname'=>$roleName,
                                    'newname'=>$desiredName
                                ));

                                $result = $curl->getData(true);
                                if($result['status']==1){
                                    $log = new ServiceLog;
                                    $log->account_id = CAuth::getLoggedId();
                                    $log->service_id = My::t('app', 'Rename character');
                                    $log->ip_address = CIp::getBinaryIp();
                                    $log->request_date = time();
                                    $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                                    $log->save();

                                    $user->coins = $user->coins - $price;
                                    $user->save();

                                    My::app()->getSession()->remove('selectedRoleId');
                                    My::app()->getSession()->remove('selectedRoleName');

                                    CCache::deleteCacheFile(md5('user'.CAuth::getLoggedParam('loggedUID').'roles').'.cch');
                                    CCache::deleteCacheFile(md5('roleinfo'.$roleId).'.cch');

                                    $msg = My::t('app', 'Successfully');
                                    $messageType = 'success';
                                }else{
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'warning';
                                }
                            }elseif($result['status']==1 and $result['data']['roleid'] !== -1){
                                $msg = My::t('app', 'Desired name is exists');
                                $messageType = 'error';
                            }else{
                                $msg = My::t('app', 'Failed');
                                $messageType = 'warning';
                            }
                        }
                    }
                }
            }
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->setMetaTags('title', My::t('app', 'Rename character'));
        $this->view->render('service/renamecharacter', $request->isAjaxRequest());
    }

    /**
     * Service chatbroadcast action handler
     */
    public function chatbroadcastAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'chatbroadcast'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                $user = User::model()->findByPk(CAuth::getLoggedId());
                $message = $request->getPost('message');
                $roleId = CAuth::getLoggedParam('selectedRoleId');
                if($roleId===null){
                    $msg = My::t('app', 'Character not selected');
                    $messageType = 'error';
                }elseif(!CValidator::validateLength($message, $service->min, $service->max)){
                    $msg = My::t('core', 'The field {title} must be between {min} and {max}!', array('{title}'=>'Message', '{min}'=>$service->min, '{max}'=>$service->max));
                    $messageType = 'error';
                }else{
                    $price = $service->price;
                    if($price > $user->coins){
                        $msg = My::t('app', 'Not enough coins');
                        $messageType = 'error';
                    }else{
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $curl->run($this->apiUrl.'server/chatbroadcast', array(
                            'channel'=>9,
                            'srcroleid'=>$roleId,
                            'srcrolename'=>CAuth::getLoggedParam('selectedRoleName'),
                            'msg'=>$message
                        ));

                        $result = $curl->getData(true);
                        if($result['status']==1){
                            $log = new ServiceLog;
                            $log->account_id = CAuth::getLoggedId();
                            $log->service_id = My::t('app', 'Chat broadcast');
                            $log->ip_address = CIp::getBinaryIp();
                            $log->request_date = time();
                            $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$price));
                            $log->save();

                            $user->coins = $user->coins - $price;
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
        }else{
            $msg = My::t('app', 'Service is currently offline.');
            $messageType = 'info';
            $this->view->offline = 1;
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->price = $service->price;
        $this->view->max = $service->max;
        $this->view->setMetaTags('title', My::t('app', 'Chat broadcast'));
        $this->view->render('service/chatbroadcast', $request->isAjaxRequest());
    }
}