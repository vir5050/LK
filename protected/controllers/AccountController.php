<?php
/**
 * AccountController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class AccountController extends CController
{
    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();

        CAuth::handleLogin('user/login');

        $this->view->response = '';
        $this->view->actionMessage = '';
    }

    /**
     * Controller default action handler
   
    public function indexAction()
    {
        $this->redirect('index/index');
    }
  */

    public function indexAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Post $model */
        $model = Post::model();

        $this->view->targetPath = 'account/index';

        $this->view->render('account/index', $request->isAjaxRequest());
    }


    /**
     * Account settings action handler
     */
    public function settingsAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->isPostRequest()){
            /** @var User $model */
            $model = User::model();
            $id = CAuth::getLoggedId();
            /*if($request->isPostExists('displayName')){
                if(APP_MODE == 'demo'){
                    $message = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $displayName = CValidator::cleanString($request->getPost('displayName'));
                    if(CValidator::validateLength($displayName, 3, 50)){
                        $model->findByPk($id);
                        $model->display_name = $displayName;
                        $model->save();

                        $message = My::t('app', 'Changes saved');
                        $messageType = 'success';

                        My::app()->getSession()->set('loggedDisplayName', $displayName);
                    }
                }
            }*/
            if($request->isPostExists('language')){
                if(APP_MODE == 'demo'){
                    $message = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $language = $request->getPost('language');
                    if(CValidator::inArray($language, array('ru', 'en'))){
                        $model->findByPk($id);
                        $model->language_id = $language;
                        $model->save();

                        My::app()->setLanguage($language);
                    }

                    $this->refresh();
                }
            }
            if($request->isPostExists('timezone')){
                if(APP_MODE == 'demo'){
                    $message = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $timezone = $request->getPost('timezone');
                    $timezones =  CTimeZone::getTimeZones();
                    if(array_key_exists($timezone, $timezones)){
                        $model->findByPk($id);
                        $model->timezone = $timezone;
                        $model->save();

                        My::app()->setTimezone($timezone);
                    }

                    $this->refresh();
                }

            }
            if($request->getPost('act') == 'changePassword'){
                if(APP_MODE == 'demo'){
                    $message = My::t('core', 'Blocked in Demo Mode.');
                    $messageType = 'warning';
                }else{
                    $result = CWidget::create('CFormValidation', array(
                        'fields'=>array(
                            'curPassword'=>array('title'=>My::t('app', 'Current password'), 'validation'=>array('required'=>true, 'type'=>'mixed', 'minLength'=>4, 'maxLength'=>20)),
                            'newPassword'=>array('title'=>My::t('app', 'New password'), 'validation'=>array('required'=>true, 'type'=>'mixed', 'minLength'=>4, 'maxLength'=>20)),
                            'passwordRetype'=>array('title'=>My::t('app', 'Retype password'), 'validation'=>array('required'=>true, 'type'=>'confirm', 'confirmField'=>'newPassword'))
                        ),
                    ));
                    if($result['error']){
                        $message = $result['errorMessage'];
                        $this->view->errorField = $result['errorField'];
                        $messageType = 'validation';
                    }else{
                        $settings = Settings::model()->findByPk(1);
                        $curPassword = ($settings->lower_passwd ? strtolower($request->getPost('curPassword')) : $request->getPost('curPassword'));
                        $newPassword = ($settings->lower_passwd ? strtolower($request->getPost('newPassword')) : $request->getPost('newPassword'));
                        $model->findByPk($id);
                        $curPassword = CHash::salt(CConfig::get('password.encryptAlgorithm'), $model->username, $curPassword);
                        $newPassword = CHash::salt(CConfig::get('password.encryptAlgorithm'), $model->username, $newPassword);

                        if($curPassword == $model->password){
                            $model->password = $newPassword;
                            $result = $model->save();

                            /** @var CCurl $curl */
                            $curl = My::app()->getCurl();
                            $curlResult = $curl->run(CConfig::get('apiUrl').'user/update', array(
                                'ID'=>$model->user_id,
                                'params'=>json_encode(array(
                                    'passwd'=>$newPassword,
                                    'passwd2'=>$newPassword
                                ))
                            ))->getData(true);

                            if($result !== false and $curlResult['status'] == 1){
                                My::app()->getCookie()->remove('auth');

                                $message = My::t('app', 'Changes saved');
                                $messageType = 'success';
                            }
                        }else{
                            $message = My::t('app', 'Wrong password.');
                            $messageType = 'error';
                        }
                    }
                }

            }
        }

        if(isset($message) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message));
        }

        $this->view->setMetaTags('title', My::t('app', 'Account settings'));
        $this->view->render('account/settings', $request->isAjaxRequest());
    }

    /**
     * Account referral action handler
     */
    public function referralAction()
    {
        if(!CConfig::get('referral.enable')) $this->redirect('index/index');

        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $this->view->referralId = CAuth::getLoggedId();
        $this->view->referralUrl = My::app()->getRequest()->getBaseUrl() . 'user/join?ref=' . CAuth::getLoggedId();
        $this->view->referrals = Referral::model()->findAll(array('condition'=>'referral_id = :referral_id', 'order'=>'referral_joined DESC'), array(':referral_id'=>(int)$this->view->referralId));
        $this->view->render('account/referral', $request->isAjaxRequest());
    }

    /**
     * Ajax helper
     */
    public function ajaxAction()
    {
        /** @var CCurl $curl */
        $curl = My::app()->getCurl();
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->isAjaxRequest()){
            switch($request->getPost('act')){
                case 'set_allow':
                    $value = $request->getPost('val');
                    if($value == 1){
                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        My::app()->getCookie()->set('auth', 'username='.$user->username.'&password='.$user->password, time() + 3600 * 24 * 14);
                    }else{
                        My::app()->getCookie()->remove('auth');
                    }

                    $this->view->response = My::t('app', 'Changes saved');
                    break;
                case 'set_ip':
                    if(APP_MODE == 'demo'){
                        exit(My::t('core', 'Blocked in Demo Mode.'));
                    }

                    /** @var User $user */
                    $user = User::model()->findByPk(CAuth::getLoggedId());
                    $value = $request->getPost('val');
                    if(!CValidator::isEmpty($value) and CValidator::isIP($value)) {
                        My::app()->getSession()->set('authIP', $value);
                        $ip = CIp::getBinaryIp($value);
                        /*$curl->run(CConfig::get('apiUrl').'user/iplimit', array(
                            'uid'=>$user->user_id,
                            'what'=>'set',
                            'ip'=>ip2long($value)
                        ));
                        $curlResult = $curl->getData(true);*/
                    }else{
                        My::app()->getSession()->set('authIP', '');
                        $ip = '';
                        /*$curl->run(CConfig::get('apiUrl').'user/iplimit', array(
                            'uid'=>$user->user_id,
                            'what'=>'delete'
                        ));
                        $curlResult = $curl->getData(true);*/
                    }

                    $user->auth_ip = $ip;
                    if($user->save()){
                        $this->view->response = My::t('app', 'Changes saved');
                    }else{
                        $this->view->response = My::t('app', 'Unknown application error.');
                    }
                    break;
                case 'get_roles':
                    $userId = CAuth::getLoggedParam('loggedUID');
                    $cacheContent = CCache::getContent(md5('user'.$userId.'roles').'.cch', 15);
                    if(!$cacheContent){
                        $result = $curl->run(CConfig::get('apiUrl').'user/roles', array(
                            'userid'=>$userId
                        ))->getData(true);

                        if($result['status'] == 1){
                            $this->view->response = json_encode($result['data']);
                            CCache::setContent($result['data']);
                        }
                    }else{
                        $this->view->response = json_encode($cacheContent);
                    }
                    break;
                case 'select_role':
                    $roleId = $request->getPost('id');
                    if(CValidator::isInteger($roleId)){
                        $userId = CAuth::getLoggedParam('loggedUID');
                        $cacheRoles = CCache::getContent(md5('user'.$userId.'roles').'.cch', 15);
                        if(!$cacheRoles){
                            $result = $curl->run(CConfig::get('apiUrl').'user/roles', array(
                                'userid'=>$userId
                            ))->getData(true);

                            if($result['status'] == 1){
                                $roles = $result['data'];
                                CCache::setContent($result['data']);
                            }
                        }else{
                            $roles = $cacheRoles;
                        }

                        if(isset($roles) and !empty($roles)){
                            foreach($roles as $role){
                                if($role['id'] == $roleId){
                                    $session = My::app()->getSession();
									$session->set('selectedRoleId', $role['id']);
                                    $session->set('selectedRoleName', $role['name']);
                                    $session->set('selectedRoleCls', $role['occupation']);
									
									$user = User::model()->findByPk(CAuth::getLoggedId());
									$user->display_name = $role['name'];
									$user->save();
									
									$session->set('loggedDisplayName', $user->display_name);

                                    $this->view->response = '1';
                                }
                            }
                        }
                    }
                    break;
                case 'get_profit':
                    if(APP_MODE == 'demo'){
                        exit(My::t('core', 'Blocked in Demo Mode.'));
                    }

                    $follower = $request->getPost('follower', 'integer');
                    if(CValidator::isInteger($follower)){
                        /** @var Referral $referral */
                        $referral = Referral::model()->findByAttributes(array('referral_id'=>CAuth::getLoggedId(), 'follower_id'=>$follower));
                        if($referral===null){
                            $this->view->response = My::t('app', 'Failed');
                        }else{
                            if($referral->follower_current_profit > 0){
                                /** @var User $user */
                                $user = User::model()->findByPk(CAuth::getLoggedId());
                                $user->coins = $user->coins + $referral->follower_current_profit;
                                if($user->save()){
                                    $referral->follower_current_profit = 0;
                                    $referral->save();

                                    $this->view->response = My::t('app', 'Successfully');
                                }else{
                                    $this->view->response = My::t('app', 'Failed');
                                }
                            }else{
                                $this->view->response = My::t('app', 'Failed');
                            }
                        }
                    }
                    break;
                case 'get_notices':
                    /** @var Notice $model */
                    $model = Notice::model();
                    $notices = $model->findAll(array('condition'=>'account_id = :account_id', 'limit'=>'0, 3', 'order'=>'obtain_date DESC'), array(':account_id'=>CAuth::getLoggedId()));
                    $this->view->response = json_encode($notices);
                    break;
                case 'accept_gift':
                    if(APP_MODE == 'demo'){
                        exit(json_encode(array('status'=>'error', 'message'=>My::t('core', 'Blocked in Demo Mode.'))));
                    }

                    /** @var Notice $model */
                    $model = Notice::model();
                    $roleId = CAuth::getLoggedParam('selectedRoleId');
                    $noticeId = $request->getPost('id');
                    if(CValidator::isInteger($noticeId) and !empty($roleId)){
                        $notice = $model->findByAttributes(array('notice_id'=>$noticeId, 'account_id'=>CAuth::getLoggedId()));
                        if($notice !== null and $notice->notice_data != ''){
                            $data = json_decode($notice->notice_data, true);
                            if($data['type'] == 'store'){
                                $item = Store::model()->findByPk($data['store_id']);
                                if($item !== null){
                                    if(isset($data['requirements']) and !empty($data['requirements'])){
                                        $requirements = null;
                                        if(isset($data['requirements']['follower'])){
                                            $user = User::model()->findByPk($data['requirements']['follower']);
                                            $cache = CCache::getContent(md5('user'.$user->user_id.'roles').'.cch', 30);
                                            if(!$cache){
                                                $result = $curl->run(CConfig::get('apiUrl').'user/roles', array(
                                                    'userid'=>$user->user_id
                                                ))->getData(true);

                                                if($result['status'] == 1){
                                                    $roles = $result['data']['roles'];
                                                    CCache::setContent($roles);
                                                }
                                            }else{
                                                $roles = $cache;
                                            }

                                            if(isset($roles) and count($roles) > 0){
                                                foreach($roles as $role){
                                                    $cache = CCache::getContent(md5('role'.$role['id'].'status').'.cch', 30);
                                                    if(!$cache){
                                                        $result = $curl->run(CConfig::get('apiUrl').'role/get', array(
                                                            'roleid'=>$role['id'],
                                                            'part'=>'status'
                                                        ))->getData(true);

                                                        if($result['status'] == 1){
                                                            $status = $result['data']['role']['status'];
                                                            CCache::setContent($status);
                                                        }
                                                    }else{
                                                        $status = $cache;
                                                    }

                                                    if(isset($status)){
                                                        if(isset($data['requirements']['level']) and $status['level'] < $data['requirements']['level']){
                                                            $requirements['level'] = My::t('app', 'Required level - {level}.', array('{level}'=>$data['requirements']['level']));
                                                        }
														
														if(isset($data['requirements']['reborn'])){
															if ($status['reborndata'] == '') {
																$requirements['reborn'] = My::t('app', 'Вам необходимо достичь {level} после перерождения.', ['{level}'=>$data['requirements']['reborn']]);
															} else {
																//$reborn = OCtet::reborn($status['reborndata']);
																if ($status['level'] < $data['requirements']['reborn']) {
																	$requirements['reborn'] = My::t('app', 'Вам необходимо достичь {level} после перерождения.', ['{level}'=>$data['requirements']['reborn']]);
																}
															}
														}
                                                    }
                                                }
                                            }else{
                                                $requirements = My::t('app', 'Failed');
                                            }
                                        }else{
                                            $cache = CCache::getContent(md5('role'.$roleId.'status').'.cch', 30);
                                            if(!$cache){
                                                $result = $curl->run(CConfig::get('apiUrl').'role/get', array(
                                                    'roleid'=>$roleId,
                                                    'part'=>'status'
                                                ))->getData(true);

                                                if($result['status'] == 1){
                                                    $status = $result['data']['role']['status'];
                                                    CCache::setContent($status);
                                                }
                                            }else{
                                                $status = $cache;
                                            }

                                            if(isset($status)){
                                                if(isset($status)){
                                                    if(isset($data['requirements']['level']) and $status['level'] < $data['requirements']['level']){
                                                        $requirements['level'] = My::t('app', 'Required level - {level}.', array('{level}'=>$data['requirements']['level']));
                                                    }
													
                                                    if(isset($data['requirements']['reborn'])){
                                                        if ($status['reborndata'] == '') {
															$requirements['reborn'] = My::t('app', 'Вам необходимо достичь {level} после перерождения.', ['{level}'=>$data['requirements']['reborn']]);
														} else {
															//$reborn = OCtet::reborn($status['reborndata']);
															if ($status['level'] < $data['requirements']['reborn']) {
																$requirements['reborn'] = My::t('app', 'Вам необходимо достичь {level} после перерождения.', ['{level}'=>$data['requirements']['reborn']]);
															}
														}
                                                    }
                                                }
                                            }
                                        }
                                    }else{
                                        $requirements = null;
                                    }

                                    if($requirements===null){
                                        $result = $curl->run(CConfig::get('apiUrl').'server/sendMail', array(
                                            'receiver'=>$roleId,
                                            'title'=>$notice->title,
                                            'context'=>$notice->message,
                                            'attach_obj'=>json_encode(array(
                                                'id'=>$item->item_id,
                                                'pos'=>0,
                                                'count'=>$data['item_count'],
                                                'max_count'=>$item->max_count,
                                                'data'=>(!empty($data['item_data']) ? $data['item_data'] : $item->octet),
                                                'proctype'=>(!empty($data['item_proctype']) ? $data['item_proctype'] : $item->proctype),
                                                'expire_date'=>(!empty($data['item_expire_date']) ? (time() + $data['item_expire_date']) : ($item->expire_date > 0 ? time() + $item->expire_date : 0)),
                                                'guid1'=>0,
                                                'guid2'=>0,
												'mask'=>$item->mask,
                                            )),
                                            'attach_money'=>0
                                        ))->getData(true);

                                        if($result['status'] == 1){
                                            $log = new StoreLog;
                                            $log->account_id = CAuth::getLoggedId();
                                            $log->store_id = $item->store_id;
                                            $log->ip_address = CIp::getBinaryIp();
                                            $log->request_date = time();
                                            $log->request_data = json_encode(array('count'=>$data['item_count'], 'total_price'=>'Gift', 'receiver'=>$roleId));
                                            $log->save();

                                            $notice->delete();

                                            $this->view->response = json_encode(array('status'=>'success', 'message'=>My::t('app', 'Item has been sent to the selected character')));
                                        }else{
                                            $this->view->response = json_encode(array('status'=>'warning', 'message'=>My::t('app', 'Failed')));
                                        }
                                    }else{
                                        $this->view->response = json_encode(array('status'=>'error', 'message'=>$requirements));
                                    }
                                }else{
                                    $this->view->response = json_encode(array('status'=>'warning', 'message'=>My::t('app', 'Failed')));
                                }
                            }else{
                                $this->view->response = json_encode(array('status'=>'warning', 'message'=>My::t('app', 'Failed')));
                            }
                        }else{
                            $this->view->response = json_encode(array('status'=>'warning', 'message'=>My::t('app', 'Failed')));
                        }
                    }else{
                        $this->view->response = json_encode(array('status'=>'error', 'message'=>My::t('app', 'Character not selected')));
                    }
                    break;
                case 'remove_notice':
                    if(APP_MODE == 'demo'){
                        exit(My::t('core', 'Blocked in Demo Mode.'));
                    }

                    /** @var Notice $model */
                    $model = Notice::model();
                    $noticeId = $request->getPost('id');
                    if(CValidator::isInteger($noticeId)){
                        $notice = $model->findByAttributes(array('notice_id'=>$noticeId, 'account_id'=>CAuth::getLoggedId()));
                        if($notice !== null){
                            if($notice->delete()){
                                $this->view->response = '1';
                            }
                        }
                    }
                    break;
            }
        }else{
            $this->redirect('index/index');
        }

        $this->view->render('account/ajax', true);
    }

    /**
     * Account allactivity action handler
     */
    public function allactivityAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var Logger $model */
        $model = Logger::model();

        $this->view->targetPath = 'account/allactivity';
        $this->view->pageSize = 30;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $model->count('account_id = :account_id', array(':account_id'=>CAuth::getLoggedId()));
        $this->view->allActivity = $model->findAll(array('condition'=>'account_id = :account_id', 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'request_date DESC'), array(':account_id'=>CAuth::getLoggedId()));
        $this->view->_urlAction = array(
            'user/login'=>'Log-in',
            'user/register'=>'Join',
            'user/recovery'=>'Access Recovery'
        );

        $this->view->setMetaTags('title', My::t('app', 'Activity Log'));
        $this->view->render('account/allactivity', $request->isAjaxRequest());
    }

    /**
     * Account storeactivity action handler
     */
    public function storeactivityAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var StoreLog $model */
        $model = StoreLog::model();

        $this->view->targetPath = 'account/storeactivity';
        $this->view->pageSize = 20;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $model->count('account_id = :account_id', array(':account_id'=>CAuth::getLoggedId()));
        $this->view->storeActivity = $model->findAll(array('condition'=>'account_id = :account_id', 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'request_date DESC'), array(':account_id'=>CAuth::getLoggedId()));

        $this->view->setMetaTags('title', My::t('app', 'Activity Log'));
        $this->view->render('account/storeactivity', $request->isAjaxRequest());
    }

    /**
     * Account serviceactivity action handler
     */
    public function serviceactivityAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        /** @var ServiceLog $model */
        $model = ServiceLog::model();

        $this->view->targetPath = 'account/serviceactivity';
        $this->view->pageSize = 20;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $model->count('account_id = :account_id', array(':account_id'=>CAuth::getLoggedId()));
        $this->view->serviceActivity = $model->findAll(array('condition'=>'account_id = :account_id', 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'request_date DESC'), array(':account_id'=>CAuth::getLoggedId()));


        $this->view->setMetaTags('title', My::t('app', 'Activity Log'));
        $this->view->render('account/serviceactivity', $request->isAjaxRequest());
    }

    /**
     * Account paymentsactivity action handler
     */
    public function paymentsactivityAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $this->view->fkActivity = '';
        $this->view->wpActivity = '';

        if(!strcasecmp($request->getQuery('system'), 'freekassa')){
            /** @var CActiveRecord $model */
            $model = Freekassa::model();
            $this->view->targetPath = 'account/paymentsactivity/system/freekassa';
            $this->view->pageSize = 20;
            $this->view->currentPage = $request->getQuery('page', 'integer', 1);
            $this->view->totalRecords = $model->count('account_id = :account_id AND status = :status', array(':account_id'=>CAuth::getLoggedId(), ':status'=>1));
            $this->view->fkActivity = $model->findAll(array('condition'=>'account_id = :account_id AND status = :status', 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'request_date DESC'), array(':account_id'=>CAuth::getLoggedId(), ':status'=>1));
        }

        if(!strcasecmp($request->getQuery('system'), 'waytopay')){
            $model = Waytopay::model();

            $this->view->targetPath = 'account/paymentsactivity/system/waytopay';
            $this->view->pageSize = 20;
            $this->view->currentPage = $request->getQuery('page', 'integer', 1);
            $this->view->totalRecords = $model->count('account_id = :account_id AND status = :status', array(':account_id'=>CAuth::getLoggedId(), ':status'=>1));
            $this->view->wpActivity = $model->findAll(array('condition'=>'account_id = :account_id AND status = :status', 'limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'request_date DESC'), array(':account_id'=>CAuth::getLoggedId(), ':status'=>1));
        }

        $this->view->setMetaTags('title', My::t('app', 'Activity Log'));
        $this->view->render('account/paymentsactivity', $request->isAjaxRequest());
    }

    /**
     * Account addfunds action handler
     */
    public function addfundsAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $this->view->merchant = $request->getQuery('merchant');

        if($request->getPost('act') == 'send' and APP_MODE !== 'demo'){
            $amount = $request->getPost('amount');
            if(CConfig::get('unitpay.enable') == true){
                if(CValidator::isInteger($amount)){
                    if($amount < CConfig::get('payment.min_amount')){
                        $amount = CConfig::get('payment.min_amount');
                    }elseif($amount > CConfig::get('payment.max_amount')){
                        $amount = CConfig::get('payment.max_amount');
                    }

                    $url = CConfig::get('unitpay.form').'?sum='.$amount.'&account='.CAuth::getLoggedName().'&desc='.urlencode(CConfig::get('unitpay.desc'));
                    header('location:'.$url);
                }
            }

            if(CConfig::get('freekassa.enable') == true){
                if(CValidator::isInteger($amount)){
                    if($amount < CConfig::get('payment.min_amount')){
                        $amount = CConfig::get('payment.min_amount');
                    }elseif($amount > CConfig::get('payment.max_amount')){
                        $amount = CConfig::get('payment.max_amount');
                    }

                    $payment = new Freekassa;
                    $payment->account_id = CAuth::getLoggedId();
                    $payment->ip_address = CIp::getBinaryIp();
                    $payment->request_date = time();
                    $payment->amount = $amount;
                    if($payment->save()){
                        $orderId = $payment->getPrimaryKey();
                        $sign = $hash = md5(CConfig::get('freekassa.merchant_id').':'.$amount.':'.CConfig::get('freekassa.secret_key').':'.$orderId);
                        $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.CConfig::get('freekassa.merchant_id').'&oa='.$amount.'&s='.$sign.'&o='.$orderId;
                        header('location:'.$url);
                    }
                }
            }
        }

        $this->view->setMetaTags('title', My::t('app', 'Donation'));
        $this->view->render('account/addfunds', $request->isAjaxRequest());
    }



    /**
     * Account vote action handler
     */
    public function voteAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $this->view->model = MmotopSettings::model()->findByPk(1);
        $this->view->setMetaTags('title', My::t('app', 'Vote'));
        $this->view->render('account/vote', $request->isAjaxRequest());
    }

    /**
     * Account successpay action handler
     */
    public function successpayAction()
    {
        $this->view->render('account/successpay');
    }

    /**
     * Account failpay action handler
     */
    public function failpayAction()
    {
        $this->view->render('account/failpay');
    }
}