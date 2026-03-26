<?php
/**
 * ReforgeController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class ReforgeController extends CController
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
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $this->view->setMetaTags('title', My::t('app', 'Reforge items'));
        $this->view->render('reforge/index', $request->isAjaxRequest());
    }

    /**
     * Reforge cells action handler
     */
    public function addcellsAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'addcells'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo') {
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $result = CWidget::create('CFormValidation', array(
                        'fields'=>array(
                            'count'=>array('title'=>My::t('app', 'Count'), 'validation'=>array('required'=>true, 'type'=>'integer', 'minLength'=>1, 'maxLength'=>1))
                        )
                    ));
                    if($result['error']){
                        $msg = $result['errorMessage'];
                        $this->view->errorField = $result['errorField'];
                        $messageType = 'validation';
                    }else{
                        $count = $request->getPost('count', 'integer', 0);
                        $roleId = CAuth::getLoggedParam('selectedRoleId');
                        if($roleId===null){
                            $msg = My::t('app', 'Character not selected');
                            $messageType = 'error';
                        }elseif($count < $service->min){
                            $msg = My::t('core', 'The field {title} must be greater than or equal to {min}!', array('{title}'=>My::t('app', 'Count'), '{min}'=>$service->min));
                            $messageType = 'error';
                        }else{
                            $user = User::model()->findByPk(CAuth::getLoggedId());
                            $price = round($count * $service->price);
                            if($price > $user->coins){
                                $msg = My::t('app', 'Not enough coins');
                                $messageType = 'error';
                            }else{
                                /** @var CCurl $curl */
                                $curl = My::app()->getCurl();
                                $curl->run($this->apiUrl.'role/get', array(
                                    'roleid'=>$roleId,
                                    'part'=>'pocket'
                                ));

                                $result = $curl->getData(true);
                                if($result['status']==1){
                                    $role = $result['data']['role'];
                                    $item = isset($role['pocket']['items'][0]) ? $role['pocket']['items'][0] : null;
                                    if(!isset($item['data']) or empty($item['data'])){
                                        $msg = My::t('app', 'Failed');
                                        $messageType = 'error';
                                    }else{
                                        $data = COctet::readItemoctet($item['data']);
                                        if($data['preq']['tag_type'] == 36 or $data['preq']['tag_type'] == 44){
                                            $cellCount = $data['stones']['cell_count'];
                                            if(($cellCount + $count) > $service->max){
                                                $msg = My::t('core', 'Max. cells - {max}', array('{max}'=>$service->max));
                                                $messageType = 'error';
                                            }else{
                                                $data['stones']['cell_count'] = $cellCount + $count;
                                                if(!isset($data['stones']['cells'])) $data['stones']['cells'] = [];
                                                for($i = 0; $i < $count; $i++){
                                                    array_push($data['stones']['cells'], array('id'=>0));
                                                }

                                                $octet = COctet::packItemdata($data);
                                                $role['pocket']['items'][0]['data'] = $octet;
                                                $curl->run($this->apiUrl.'role/put', array(
                                                    'roleid'=>$roleId,
                                                    'value'=>json_encode($role),
                                                    'part'=>'pocket'
                                                ));

                                                $result = $curl->getData(true);
                                                if($result['status']==1){
                                                    $log = new ServiceLog;
                                                    $log->account_id = CAuth::getLoggedId();
                                                    $log->service_id = My::t('app', 'Add cells');
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
                                }else{
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'warning';
                                }
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
        $this->view->setMetaTags('title', My::t('app', 'Add cells'));
        $this->view->render('reforge/addcells', $request->isAjaxRequest());
    }

    /**
     * Reforge attackrange action handler
     */
    public function attackrangeAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'attackrange'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo'){
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
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
                        $count = $request->getPost('count', 'integer', 0);
                        $roleId = CAuth::getLoggedParam('selectedRoleId');
                        if($roleId===null){
                            $msg = My::t('app', 'Character not selected');
                            $messageType = 'error';
                        }elseif($count < $service->min){
                            $msg = My::t('core', 'The field {title} must be greater than or equal to {min}!', array('{title}'=>My::t('app', 'Count'), '{min}'=>$service->min));
                            $messageType = 'error';
                        }else{
                            $user = User::model()->findByPk(CAuth::getLoggedId());
                            $price = round($count * $service->price);
                            if($price > $user->coins){
                                $msg = My::t('app', 'Not enough coins');
                                $messageType = 'error';
                            }else{
                                /** @var CCurl $curl */
                                $curl = My::app()->getCurl();
                                $curl->run($this->apiUrl.'role/get', array(
                                    'roleid'=>$roleId,
                                    'part'=>'pocket'
                                ));

                                $result = $curl->getData(true);
                                if($result['status']==1){
                                    $role = $result['data']['role'];
                                    $item = isset($role['pocket']['items'][0]) ? $role['pocket']['items'][0] : null;
                                    if(!isset($item['data']) or empty($item['data'])){
                                        $msg = My::t('app', 'Failed');
                                        $messageType = 'error';
                                    }else{
                                        $data = COctet::readItemoctet($item['data']);
                                        if($data['preq']['tag_type'] == 44){
                                            $attackRange = (float)$data['essence']['attack_range'];
                                            $range = round((float)$attackRange + (float)$count, 2);
                                            if($range > $service->max){
                                                $msg = My::t('core', 'Max. range - {max}', array('{max}'=>$service->max));
                                                $messageType = 'error';
                                            }else{
                                                $data['essence']['attack_range'] = $range;
                                                $octet = COctet::packItemdata($data);
                                                $role['pocket']['items'][0]['data'] = $octet;
                                                $curl->run($this->apiUrl.'role/put', array(
                                                    'roleid'=>$roleId,
                                                    'value'=>json_encode($role),
                                                    'part'=>'pocket'
                                                ));

                                                $result = $curl->getData(true);
                                                if($result['status']==1){
                                                    $log = new ServiceLog;
                                                    $log->account_id = CAuth::getLoggedId();
                                                    $log->service_id = My::t('app', 'Add attack range');
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
                                }else{
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'warning';
                                }
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
        $this->view->setMetaTags('title', My::t('app', 'Add attack range'));
        $this->view->render('reforge/attackrange', $request->isAjaxRequest());
    }

    /**
     * Reforge attackspeed action handler
     */
    public function attackspeedAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'attackspeed'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo'){
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $count = $request->getPost('count', 'integer', 0);
                    $roleId = CAuth::getLoggedParam('selectedRoleId');
                    if($roleId===null){
                        $msg = My::t('app', 'Character not selected');
                        $messageType = 'error';
                    }elseif(!CValidator::isInteger($count) and !CValidator::validateRange($count, 1, 50)){
                        $msg = My::t('core', 'Failed');
                        $messageType = 'error';
                    }else{
                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        $price = round($count * $service->price);
                        if($price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $curl->run($this->apiUrl.'role/get', array(
                                'roleid'=>$roleId,
                                'part'=>'pocket'
                            ));

                            $result = $curl->getData(true);
                            if($result['status']==1){
                                $role = $result['data']['role'];
                                $item = isset($role['pocket']['items'][0]) ? $role['pocket']['items'][0] : null;
                                if(!isset($item['data']) or empty($item['data'])){
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'error';
                                }else{
                                    $data = COctet::readItemoctet($item['data']);
                                    if($data['preq']['tag_type'] == 44){
                                        $attackSpeed = $data['essence']['attack_speed'];
                                        if($attackSpeed == $service->max){
                                            $msg = My::t('core', 'Max. speed - {max}', array('{max}'=>round(20 / $service->max, 2).'.00'));
                                            $messageType = 'error';
                                        }else{
                                            $speed = self::calculateAttackSpeed($attackSpeed, $count);
                                            if($speed >= $service->max){
                                                $data['essence']['attack_speed'] = $speed;
                                                $octet = COctet::packItemdata($data);
                                                $role['pocket']['items'][0]['data'] = $octet;
                                                $curl->run($this->apiUrl.'role/put', array(
                                                    'roleid'=>$roleId,
                                                    'value'=>json_encode($role),
                                                    'part'=>'pocket'
                                                ));

                                                $result = $curl->getData(true);
                                                if($result['status']==1){
                                                    $log = new ServiceLog;
                                                    $log->account_id = CAuth::getLoggedId();
                                                    $log->service_id = My::t('app', 'Add attack speed');
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
                                            }else{
                                                $msg = My::t('core', 'Max. speed - {max}', array('{max}'=>round(20 / $service->max, 2).'.00'));
                                                $messageType = 'error';
                                            }
                                        }
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
        $this->view->setMetaTags('title', My::t('app', 'Add attack speed'));
        $this->view->render('reforge/attackspeed', $request->isAjaxRequest());
    }

    /**
     * Reforge cells action handler
     */
    public function distancefragilityAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'distancefragility'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo'){
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $roleId = CAuth::getLoggedParam('selectedRoleId');
                    if($roleId===null){
                        $msg = My::t('app', 'Character not selected');
                        $messageType = 'error';
                    }else{
                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        $price = $service->price;
                        if($price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $curl->run($this->apiUrl.'role/get', array(
                                'roleid'=>$roleId,
                                'part'=>'pocket'
                            ));

                            $result = $curl->getData(true);
                            if($result['status']==1){
                                $role = $result['data']['role'];
                                $item = $role['pocket']['items'][0];
                                if(empty($item['data'])){
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'error';
                                }else{
                                    $data = COctet::readItemoctet($item['data']);
                                    if($data['preq']['tag_type'] == 44){
                                        $data['essence']['attack_short_range'] = 0;
                                        $octet = COctet::packItemdata($data);
                                        $role['pocket']['items'][0]['data'] = $octet;
                                        $curl->run($this->apiUrl.'role/put', array(
                                            'roleid'=>$roleId,
                                            'value'=>json_encode($role),
                                            'part'=>'pocket'
                                        ));

                                        $result = $curl->getData(true);
                                        if($result['status']==1){
                                            $log = new ServiceLog;
                                            $log->account_id = CAuth::getLoggedId();
                                            $log->service_id = My::t('app', 'Delete distance fragility');
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
        $this->view->setMetaTags('title', My::t('app', 'Delete distance fragility'));
        $this->view->render('reforge/distancefragility', $request->isAjaxRequest());
    }

    /**
     * Reforge itemcreator action handler
     */
    public function itemcreatorAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'itemcreator'));
        if($service->enable == 1){
            if($request->getPost('act') == 'send'){
                if(APP_MODE == 'demo'){
                    $msg = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $name = $request->getPost('name');
                    $color = $request->getPost('color');
                    $roleId = CAuth::getLoggedParam('selectedRoleId');
                    if($roleId===null){
                        $msg = My::t('app', 'Character not selected');
                        $messageType = 'error';
                    }elseif(!CValidator::validateLength($name, $service->min, $service->max)){
                        $msg = My::t('core', 'The field {title} must be between {min} and {max}!', array('{title}'=>'Name', '{min}'=>$service->min, '{max}'=>$service->max));
                        $messageType = 'error';
                    }elseif(!CValidator::detectEncoding($name, $service->value)){
                        $msg = My::t('app', 'Failed');
                        $messageType = 'error';
                    }elseif(!CValidator::isHexColor($color)){
                        $msg = My::t('app', 'Failed');
                        $messageType = 'error';
                    }else{
                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        $price = $service->price;
                        if($price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }else{
                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $curl->run($this->apiUrl.'role/get', array(
                                'roleid'=>$roleId,
                                'part'=>'pocket'
                            ));

                            $result = $curl->getData(true);
                            if($result['status']==1){
                                $role = $result['data']['role'];
                                $item = isset($role['pocket']['items'][0]) ? $role['pocket']['items'][0] : null;
                                if(!isset($item['data']) or empty($item['data'])){
                                    $msg = My::t('app', 'Failed');
                                    $messageType = 'error';
                                }else{
                                    $data = COctet::readItemoctet($item['data']);
                                    if($data['preq']['tag_type'] == 36 or $data['preq']['tag_type'] == 44){
                                        $name = str_replace('#', '^', $color).$name;
                                        $data['preq']['tag_size'] = mb_strlen($name);
                                        $data['preq']['tag_content'] = $name;
                                        $octet = COctet::packItemdata($data);
                                        $role['pocket']['items'][0]['data'] = $octet;
                                        $curl->run($this->apiUrl.'role/put', array(
                                            'roleid'=>$roleId,
                                            'value'=>json_encode($role),
                                            'part'=>'pocket'
                                        ));

                                        $result = $curl->getData(true);
                                        if($result['status']==1){
                                            $log = new ServiceLog;
                                            $log->account_id = CAuth::getLoggedId();
                                            $log->service_id = My::t('app', 'Change item creator');
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
        $this->view->setMetaTags('title', My::t('app', 'Change item creator'));
        $this->view->render('reforge/itemcreator', $request->isAjaxRequest());
    }

    private function calculateAttackSpeed($speed, $add = 0.00)
    {
        return round(20 / (float)(round(20 / $speed, 2) + (float)round($add / 10, 2)));
    }
}