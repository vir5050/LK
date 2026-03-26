<?php
/**
 * UserController
 *
 * PUBLIC:					PROTECTED:						PRIVATE:
 * ----------			   ----------					  ----------
 * __construct             authenticate
 * indexAction
 * loginAction
 * joinAction
 * recoveryAction
 * resetAccessAction
 * logoutAction
 *
 */

class UserController extends CController
{
    /**	@var boolean */
    private $checkBruteforce;
    /**	@var int */
    private $redirectDelay;
    /**	@var int */
    private $badLogins;
    /**	@var string */
    private $apiUrl;

    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();

        //$this->view->setTemplate('user');
        $this->view->errorMessage = '';
        $this->view->actionMessage = '';
        $this->view->errorField = '';
        $this->view->username = '';
        $this->view->password = '';
        $this->view->remember = '';
        $this->view->email = '';
        $this->view->passwordRetype = '';
        $this->view->referral = '';
        $this->view->gift = '';

        $this->checkBruteforce = CConfig::get('validation.bruteforce.enable');
        $this->redirectDelay = (int)CConfig::get('validation.bruteforce.redirectDelay', 3);
        $this->badLogins = (int)CConfig::get('validation.bruteforce.badLogins', 5);
        $this->apiUrl = CConfig::get('apiUrl');
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        $this->redirect('user/login');
    }

    /**
     * User login action handler
     */
    public function loginAction()
    {
        CAuth::handleLoggedIn('index/index');

        $settings = Settings::model()->findByPk(1);
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->getPost('act') == 'send'){
            $this->view->username = $request->getPost('username');
            $this->view->password = $request->getPost('password');
            $this->view->remember = $request->getPost('remember', 'string');

            $result = CWidget::create('CFormValidation', array(
                'fields'=>array(
                    My::app()->getRequest()->getCaptchaKey()=>array('title'=>My::t('app', 'Code from picture'), 'validation'=>array('required'=>CConfig::get('validation.captcha.login'), 'type'=>'captcha')),
                    'username'=>array('title'=>My::t('app', 'Username'), 'validation'=>array('required'=>true, 'type'=>'mixed', 'minLength'=>3, 'maxLength'=>20)),
                    'password'=>array('title'=>My::t('app', 'Password'), 'validation'=>array('required'=>true, 'type'=>'mixed', 'minLength'=>3, 'maxLength'=>20)),
                    'remember'=>array('title'=>My::t('app', 'Remember me'), 'validation'=>array('required'=>false, 'type'=>'set', 'source'=>array(0,1)))
                )
            ));
            if($result['error']){
                $msg = $result['errorMessage'];
                $this->view->errorField = $result['errorField'];
                $messageType = 'validation';
            }else{
                if($settings->lower_login) $this->view->username = strtolower($this->view->username);
                if($settings->lower_passwd) $this->view->password = strtolower($this->view->password);

                $password = CHash::salt(CConfig::get('password.encryptAlgorithm'), $this->view->username, $this->view->password);
                if($this->authenticate($this->view->username, $password, $this->view->remember)===true){
                    CAuth::handleLoggedIn();
                }else{
                    $msg = $this->view->errorMessage;
                    $messageType = 'error';
                }
            }
        }else{
            if($this->checkBruteforce){
                $logAttempts = My::app()->getSession()->get('loginAttempts', 1);
                $logAttemptsAuthCookie = My::app()->getCookie()->get('userAttemptsAuth');
                $logAttemptsAuthPost = $request->getPost('userAttemptsAuth');
                if($logAttempts >= $this->badLogins){
                    if($logAttemptsAuthCookie != '' and $logAttemptsAuthCookie == $logAttemptsAuthPost){
                        My::app()->getSession()->remove('loginAttempts');
                        My::app()->getCookie()->remove('userAttemptsAuth');
                        $this->redirect('user/login');
                    }
                }
            }
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));

            if($this->checkBruteforce and $messageType == 'error'){
                $logAttempts = My::app()->getSession()->get('loginAttempts', 1);
                if($logAttempts < $this->badLogins){
                    My::app()->getSession()->set('loginAttempts', $logAttempts+1);
                }else{
                    My::app()->getCookie()->set('userAttemptsAuth', md5(uniqid()));
                    sleep($this->redirectDelay);
                    $this->redirect('user/login');
                }
            }
        }

        $this->view->render('user/login');
    }

    /**
     * User join action handler
     */
    public function joinAction()
    {
        CAuth::handleLoggedIn('index/index');

        $settings = Settings::model()->findByPk(1);
        if($settings->registration_gift != ''){
            $gifts = explode(',', str_replace(' ', '', $settings->registration_gift));
            $giftList = array();

            foreach($gifts as $gift){
                $store = Store::model()->findByPk($gift);
                if($store!==null){
                    $giftList[$gift] = CHtml::link(CHtml::image('uploads/Icons/'.$store->item_id.'.png', $store->name), 'store/ajax/preview/'.$store->store_id, array('onclick'=>'this.parentNode.click(); return false;', 'onmouseover'=>'showTooltip(this, \'Preview\', {target:this.parentNode, tipJoint:\'bottom\', ajax:true, offset:[0, -10]});'));
                }
            }
            $this->view->gift = $gifts[0];
        }

        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->getPost('act') == 'send'){
            if(APP_MODE == 'demo'){
                $msg = My::t('core', 'This operation is blocked in Demo Mode!');
                $messageType = 'warning';
            }else{
                $this->view->username = $request->getPost('username');
                $this->view->password = $request->getPost('password');
                $this->view->passwordRetype = $request->getPost('passwordRetype');
                $this->view->email = $request->getPost('email');
                $this->view->referral = $request->getPost('referral');
                $this->view->gift = $request->getPost('gift');

                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        My::app()->getRequest()->getCaptchaKey()=>array('title'=>My::t('app', 'Code from picture'), 'validation'=>array('required'=>CConfig::get('validation.captcha.join'), 'type'=>'captcha')),
                        'username'=>array('title'=>My::t('app', 'Username'), 'validation'=>array('required'=>true, 'type'=>'mixed', 'minLength'=>3, 'maxLength'=>20)),
                        'password'=>array('title'=>My::t('app', 'Password'), 'validation'=>array('required'=>true, 'type'=>'mixed', 'minLength'=>3, 'maxLength'=>20)),
                        'passwordRetype'=>array('title'=>My::t('app', 'Retype password'), 'validation'=>array('required'=>true, 'type'=>'confirm', 'confirmField'=>'password')),
                        'email'=>array('title'=>My::t('app', 'Email'), 'validation'=>array('required'=>true, 'type'=>'email')),
                        'referral'=>array('title'=>My::t('app', 'Referral program'), 'validation'=>array('required'=>false, 'type'=>'integer', 'minLength'=>1, 'maxLength'=>10))
                    ),
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    if($settings->lower_login) $this->view->username = strtolower($this->view->username);
                    if($settings->lower_passwd) $this->view->password = strtolower($this->view->password);

                    CDatabase::init()->cacheOff();

                    $checkName = User::model()->findByAttributes(array('username'=>$this->view->username));
                    $checkEmail = User::model()->findByAttributes(array('email'=>$this->view->email));
                    if(!empty($checkName)){
                        $msg = My::t('app', 'Username already exists.');
                        $this->view->username = '';
                        $this->view->errorField = 'username';
                        $messageType = 'error';
                    }elseif(!empty($checkEmail)){
                        $msg = My::t('app', 'Email Address already used.');
                        $this->view->email = '';
                        $this->view->errorField = 'email';
                        $messageType = 'error';
                    }elseif($this->view->username == $this->view->password){
                        $msg = My::t('app', 'Username and password must not be the same.');
                        $this->view->password = '';
                        $this->view->errorField = 'password';
                        $messageType = 'error';
                    }else{
                        /** @var CCurl $curl */
                        $curl = My::app()->getCurl();
                        $password = CHash::salt(CConfig::get('password.encryptAlgorithm'), $this->view->username, $this->view->password);
                        $curlCheck = $curl->run($this->apiUrl.'user/get', array(
                            'name'=>$this->view->username
                        ))->getData(true);

                        if(!$curl->hasErrors()){
                            $userId = null;
                            $coins = 0;
                            $bonuses = 0;
                            if($curlCheck['error'] == 2){
                                $curlResult = $curl->run($this->apiUrl.'user/register', array(
                                    'name'=>$this->view->username,
                                    'passwd'=>$password,
                                    'email'=>$this->view->email
                                ))->getData(true);

                                if($curlResult['status'] == 1){
                                    $userId = $curlResult['data']['user_id'];
                                }

                                $myReferral = User::model()->findByPk($this->view->referral);
                                if($myReferral!==null){
                                    $myReferral = $myReferral->id;
                                }else{
                                    $myReferral = null;
                                }
                            }elseif($curlCheck['status'] == 1 and $curlCheck['data']['user']['passwd'] == $password){
                                $userId = $curlCheck['data']['user']['ID'];
                                $coins = $curlCheck['data']['user']['money'];
                                $bonuses = $curlCheck['data']['user']['bonuses'];
                            }

                            if($userId !== null){
                                $user = new User;
                                $user->username = $this->view->username;
                                $user->password = $password;
                                $user->display_name = $this->view->username;
                                $user->email = $this->view->email;
                                $user->language_id = My::app()->getLanguage();
                                $user->register_date = time();
                                $user->user_state = ($settings->email_secure ? 'email_confirm' : 'valid');
                                $user->user_id = $userId;
                                $user->coins = $coins;
                                $user->bonuses = $bonuses;
                                if($user->save()){
                                    $user = User::model()->findByAttributes(array('username'=>$this->view->username));

                                    if($settings->cubigold_onstart){
                                        $cubigold = $curl->run($this->apiUrl.'user/cubigold', array(
                                            'id'=>$user->user_id,
                                            'count'=>round($settings->cubigold_count * 100)
                                        ))->getData(false);
                                    }else{
                                        $cubigold  = 'disabled';
                                    }

                                    $refSettings = CConfig::get('referral');
                                    if(isset($myReferral) and $myReferral !== null and $refSettings['enable'] == true){
                                        $binaryIp = CIp::getBinaryIp();
                                        $actionsCount = Logger::model()->countByAttributes(array('ip_address'=>$binaryIp));
                                        $actionsCount += Freekassa::model()->countByAttributes(array('ip_address'=>$binaryIp));
                                        $actionsCount += Mmotop::model()->countByAttributes(array('ip'=>CIp::convertIpBinaryToString($binaryIp)));
                                        $actionsCount += ServiceLog::model()->countByAttributes(array('ip_address'=>$binaryIp));
                                        $actionsCount += StoreLog::model()->countByAttributes(array('ip_address'=>$binaryIp));
                                        //$actionsCount += Waytopay::model()->countByAttributes(array('ip_address'=>$binaryIp));
                                        if($actionsCount == 0){
                                            $referral = new Referral;
                                            $referral->referral_id = $myReferral;
                                            $referral->follower_id = $user->id;
                                            $referral->referral_joined = $user->register_date;

                                            if($refSettings['ingameitems']['enable'] == true){
                                                foreach($refSettings['ingameitems']['referral'] as $item){
                                                    if(isset($item['requirements'])){
                                                        $item['requirements']['follower'] = $referral->follower_id;
                                                    }

                                                    $data = array(
                                                        'type'=>'store',
                                                        'store_id'=>$item['id'],
                                                        'item_count'=>$item['count'],
                                                        'requirements'=>(isset($item['requirements']) ? $item['requirements'] : '')
                                                    );

                                                    $notice = new Notice;
                                                    $notice->account_id = $referral->referral_id;
                                                    $notice->title = My::t('app', 'New item');
                                                    $notice->message = My::t('app', 'New follower');
                                                    $notice->obtain_date = time();
                                                    $notice->notice_data = json_encode($data);
                                                    $notice->save();
                                                }

                                                foreach($refSettings['ingameitems']['follower'] as $item){
                                                    $data = array(
                                                        'type'=>'store',
                                                        'store_id'=>$item['id'],
                                                        'item_count'=>$item['count'],
                                                        'requirements'=>(isset($item['requirements']) ? $item['requirements'] : '')
                                                    );

                                                    $notice = new Notice;
                                                    $notice->account_id = $referral->follower_id;
                                                    $notice->title = My::t('app', 'New item');
                                                    $notice->message = My::t('app', 'New follower');
                                                    $notice->obtain_date = time();
                                                    $notice->notice_data = json_encode($data);
                                                    $notice->save();
                                                }
                                            }
                                            $referral->save();
                                        }
                                    }

                                    if(isset($gifts) and in_array($this->view->gift, $gifts)){
                                        $gift = Store::model()->findByPk($this->view->gift);
                                        if($gift!==null){
                                            $data = array(
                                                'type'=>'store',
                                                'store_id'=>$gift->store_id,
                                                'item_count'=>$gift->count
                                            );

                                            $notice = new Notice;
                                            $notice->account_id = $user->id;
                                            $notice->title = My::t('app', 'New item');
                                            $notice->message = My::t('app', 'Registration gift');
                                            $notice->obtain_date = time();
                                            $notice->notice_data = json_encode($data);
                                            $notice->save();
                                        }
                                    }

                                    $logger = new Logger;
                                    $logger->account_id = $user->id;
                                    $logger->ip_address = CIp::getBinaryIp();
                                    $logger->request_date = time();
                                    $logger->request_url = 'user/register';
                                    $logger->request_data = 'cubigold_onstart: '.$cubigold;
                                    $logger->save();

                                    if($this->authenticate($user->username, $user->password, true, 0)===true){
                                        CAuth::handleLoggedIn();
                                    }else{
                                        $msg = My::t('app', 'Congratulations! Registration was successful.');
                                        $messageType = 'success';
                                    }
                                }else{
                                    $msg = My::t('app', 'Database error.');
                                    $messageType = 'warning';
                                }
                            }else{
                                $msg = My::t('app', 'Unknown application error.');
                                $messageType = 'warning';
                            }
                        }else{
                            $msg = My::t('app', 'Unknown application error.');
                            $messageType = 'warning';
                        }
                    }
                }
            }
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->giftList = isset($giftList) ? $giftList : '';
        $this->view->setMetaTags('title', My::t('app', 'Create an account'));
        $this->view->render('user/join');
    }

    /**
     * User recovery action handler
     */
    public function recoveryAction()
    {
        CAuth::handleLoggedIn('index/index');

        $settings = Settings::model()->findByPk(1);
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->getPost('act') == 'send'){
            if(APP_MODE == 'demo'){
                $msg = My::t('core', 'This operation is blocked in Demo Mode!');
                $messageType = 'warning';
            }else{
                $this->view->email = $request->getPost('email');
                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        My::app()->getRequest()->getCaptchaKey()=>array('title'=>My::t('app', 'Code from picture'), 'validation'=>array('required'=>CConfig::get('validation.captcha.recovery'), 'type'=>'captcha')),
                        'email'=>array('title'=>My::t('app', 'Email'), 'validation'=>array('required'=>true, 'type'=>'email'))
                    ),
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    $user = User::model()->findByAttributes(array('email'=>$this->view->email));
                    if($user===null){
                        $msg = My::t('app', 'User not found.');
                        $this->view->errorField = 'email';
                        $messageType = 'error';
                    }else{
                        $key = md5(time().$user->id);
                        $change = UserChange::model();
                        $change->user_id = $user->id;
                        $change->change_key = $key;
                        $change->new_value = CHash::getRandomString(6);
                        $change->create_date = time();
                        $change->expiry_date = 1800;
                        $result = $change->save();

                        if(!$result){
                            $change = UserChange::model()->findByAttributes(array('user_id'=>$user->id));
                            if($change!==null){
                                $key = $change->change_key;
                            }
                        }

                        if(!empty($key)){
                            if($settings->mailer == 'smtpMailer'){
                                $smtp_password = CHash::decrypt($settings->smtp_password, CConfig::get('installationKey'));
                                $config = array(
                                    'mailer'=>$settings->mailer,
                                    'smtp_secure'=>$settings->smtp_secure,
                                    'smtp_host'=>$settings->smtp_host,
                                    'smtp_port'=>$settings->smtp_port,
                                    'smtp_username'=>$settings->smtp_username,
                                    'smtp_password'=>$smtp_password
                                );
                            }else{
                                $config = array('mailer'=>$settings->mailer);
                            }

                            CMailer::config($config);
                            $nl = '<br>';
                            $mailHead = My::t('app', 'Access Recovery');
                            $mailBody = My::t('app', 'Somebody recently asked to reset access your Account on server {name}.', array('{name}'=>CConfig::get('name'))).$nl;
                            $mailBody .= '<a style="margin-top:10px;display:block;font-family:inherit;color:#3b5998;" href="'.My::app()->getRequest()->getBaseUrl().'user/resetAccess/key/'.$key.'">'.My::t('app', 'Click here to proceed.').'</a>'.$nl.$nl;
                            $mailBody .= My::t('app', 'This message was sent to {email} at your request.', array('{email}'=>$user->email)).$nl.$nl;
                            $mailBody .= My::t('app', 'You did not make this request? Let us know immediately.');
                            $mailFooter = My::t('app', 'Mail Signature', array('{name}'=>CConfig::get('name')));
                            $body = CMailer::defaultEmailStyle($mailHead, $mailBody, $mailFooter);

                            if(CMailer::send($user->email, My::t('app', 'Access Recovery'), $body, array('from'=>$settings->general_email, 'from_name'=>CConfig::get('name')))){
                                $msg = My::t('app', 'Further instructions have been sent to your email address.');
                                $messageType = 'success';

                                $logger = new Logger;
                                $logger->account_id = $user->id;
                                $logger->ip_address = CIp::getBinaryIp();
                                $logger->request_date = time();
                                $logger->request_url = 'user/recovery';
                                $logger->request_data = 'email was sent successfully';
                                $logger->save();
                                unset($logger);
                            }else{
                                $msg = My::t('app', 'Unable to send email.').$nl.CMailer::getError();
                                $messageType = 'error';
                                CDebug::addMessage('errors', 'email_send', CMailer::getError());
                            }
                        }else{
                            $msg = My::t('app', 'Unknown application error.');
                        }
                    }
                }
            }
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Access Recovery'));
        $this->view->render('user/recovery');
    }

    /**
     * User resetAccess action handler
     */
    public function resetAccessAction()
    {
        CAuth::handleLoggedIn('index/index');

        $settings = Settings::model()->findByPk(1);
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->getQuery('key') !== ''){
            if(APP_MODE == 'demo'){
                $msg = My::t('core', 'This operation is blocked in Demo Mode!');
                $messageType = 'warning';
            }else{
                $key = $request->getQuery('key');
                if(CValidator::isValidMd5($key)){
                    $change = UserChange::model()->findByAttributes(array('change_key'=>$key));
                    if($change===null){
                        $msg = My::t('app', 'Unknown application error.');
                        $messageType = 'error';
                    }elseif($change->expiry_date < (time() - $change->create_date)){
                        UserChange::model()->deleteByPk($change->user_change_temp_id);
                        unset($change);

                        $msg = 'Expired';
                        $messageType = 'error';
                    }else{
                        $user = User::model()->findByPk($change->user_id);
                        if($user!==null){
                            $password = CHash::salt(CConfig::get('password.encryptAlgorithm'), $user->username, $change->new_value);

                            $user->auth_ip = '';
                            $user->password = $password;
                            $result = $user->save();

                            $curl = My::app()->getCurl();
                            $curlResult = $curl->run($this->apiUrl.'user/update', array(
                                'ID'=>$user->user_id,
                                'params'=>json_encode(array(
                                    'passwd'=>$password,
                                    'passwd2'=>$password
                                ))
                            ))->getData(true);

                            if($result !== false and $curlResult['status'] == 1){
                                if($settings->mailer == 'smtpMailer'){
                                    $smptPassword = CHash::decrypt($settings->smtp_password, CConfig::get('installationKey'));
                                    $config = array(
                                        'mailer'=>$settings->mailer,
                                        'smtp_secure'=>$settings->smtp_secure,
                                        'smtp_host'=>$settings->smtp_host,
                                        'smtp_port'=>$settings->smtp_port,
                                        'smtp_username'=>$settings->smtp_username,
                                        'smtp_password'=>$smptPassword,
                                    );
                                }else{
                                    $config = array('mailer'=>$settings->mailer);
                                }

                                CMailer::config($config);

                                $mailHead = My::t('app', 'Access Recovery');
                                $mailBody = My::t('app', 'For user {username} was set a new password: {password}', array('{username}'=>$user->username, '{password}'=>$change->new_value));
                                $mailBody .= '<a style="margin-top:10px;display:block;font-family:inherit;color:#3b5998;" href="'.My::app()->getRequest()->getBaseUrl().'account/settings/">'.My::t('app', 'Change current password').'</a>';
                                $mailFooter = My::t('app', 'Mail Signature', array('{name}'=>CConfig::get('name')));
                                $body = CMailer::defaultEmailStyle($mailHead, $mailBody, $mailFooter);

                                if(CMailer::send($user->email, My::t('app', 'Access Recovery'), $body, array('from'=>$settings->general_email, 'from_name'=>CConfig::get('name')))){
                                    UserChange::model()->deleteByPk($change->user_change_temp_id);
                                    unset($change);

                                    $msg = My::t('app', 'All authorization settings have been reset. A new password has been sent to your email.');
                                    $messageType = 'success';
                                    $emailSuccessSent = 1;
                                }else{
                                    $msg = My::t('app', 'Unable to send email.');
                                    $messageType = 'error';
                                    $emailSuccessSent = 0;
                                    CDebug::addMessage('errors', 'email_send', CMailer::getError());
                                }
                            }else{
                                $msg = My::t('app', 'Unknown application error.');
                                $messageType = 'error';
                            }

                            if(isset($emailSuccessSent)){
                                $logger = new Logger;
                                $logger->account_id = $user->id;
                                $logger->ip_address = CIp::getBinaryIp();
                                $logger->request_date = time();
                                $logger->request_url = 'user/resetAccess';
                                $logger->request_data = 'email: '.$emailSuccessSent.' || server:{user/update: '.json_encode($curlResult).'}';
                                $logger->save();
                            }
                        }
                    }
                }
            }
        }

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Access Recovery'));
        $this->view->render('user/reset');
    }

    /**
     * User logout action handler
     */
    public function logoutAction()
    {
        My::app()->getSession()->endSession();
        My::app()->getCookie()->remove('auth');
        My::app()->getCookie()->remove('token');
        $this->redirect('index/index');
    }

    /**
     * User auth
     * @param $username
     * @param $password
     * @param bool $remember
     * @param int $fromCookie
     * @return void|bool
     */
    protected function authenticate($username, $password, $remember = false, $fromCookie = 0)
    {
        CDatabase::init()->cacheOff();

        $settings = Settings::model()->findByPk(1);
        $user = User::model()->findByAttributes(array('username'=>$username));
        if($user===null){
            /** @var CCurl $curl */
            $curl = My::app()->getCurl();
            $result = $curl->run($this->apiUrl.'user/get', array(
                'name'=>$username
            ))->getData(true);

            if($result['status'] == 1 and $result['data']['user']['passwd'] == $password){
                $pwUser = $result['data']['user'];
            }

            if(isset($pwUser)){
                $user = new User;
                $user->username = $username;
                $user->password = $password;
                $user->display_name = $username;
                $user->email = (isset($pwUser['email']) ? $pwUser['email'] : '');
                $user->language_id = My::app()->getLanguage();
                $user->register_date = strtotime($pwUser['creatime']);
                $user->user_state = ($settings->email_secure ? 'email_confirm' : 'valid');
                $user->user_id = $pwUser['ID'];
                $user->coins = $pwUser['money'];
                $user->bonuses = $pwUser['bonuses'];
                if($user->save()){
                    return $this->authenticate($username, $password, $remember);
                }else{
                    $this->view->errorMessage = My::t('app', 'Database error.');
                    $this->view->username = '';
                    $this->view->password = '';
                }
            }else{
                $this->view->errorMessage = My::t('app', 'User not found.');
                $this->view->errorField = 'username';
                $this->view->username = '';
                $this->view->password = '';
            }

            $this->view->errorMessage = My::t('app', 'User not found.');
            $this->view->errorField = 'username';
            $this->view->username = '';
            $this->view->password = '';
        }else{
            if($password == $user->password){
                if($settings->email_secure == 1 and $user->user_state == 'email_confirm'){
                    $this->view->errorMessage = My::t('app', 'To use your account, you need to confirm the email address.');
                    $this->view->username = '';
                    $this->view->password = '';
                }else{
                    if($user->is_banned == 1){
                        $this->view->errorMessage = My::t('app', 'Your account has been blocked.');
                        $this->view->username = '';
                        $this->view->password = '';
                    }elseif($user->auth_ip != '' and false === (CIp::getBinaryIp() === $user->auth_ip)){
                        $this->view->errorMessage = My::t('app', 'Your IP Address does not match with specified.');
                        $this->view->username = '';
                        $this->view->password = '';
                    }else{
                        /** @var CHttpCookie $cookie */
                        $cookie = My::app()->getCookie();
                        /** @var CHttpSession $session */
                        $session = My::app()->getSession();

                        $session->set('loggedIn', true);
                        $session->set('loggedId', $user->id);
                        $session->set('loggedName', $user->username);
                        $session->set('loggedDisplayName', $user->display_name);
                        $session->set('loggedEmail', $user->email);
                        $session->set('loggedUserId', $user->user_id);
                        $session->set('loggedLastVisit', $user->lastvisited_at);
                        $session->set('loggedRole', $user->role);
                        $session->set('loggedUID', $user->user_id);
                        $session->set('isStaff', $user->is_staff);
                        $session->set('authIP', CIp::convertIpBinaryToString($user->auth_ip));

                        My::app()->setLanguage($user->language_id);
                        My::app()->setTimezone($user->timezone);

                        if($remember){
                            $cookie->set('auth', 'username='.$username.'&password='.$password, time() + 3600 * 24 * 14);
			    $cookie->set('token', ''.$username.'');
                        }

                        if(APP_MODE != 'demo'){
                            $logger = new Logger;
                            $logger->account_id = $user->id;
                            $logger->ip_address = CIp::getBinaryIp();
                            $logger->request_date = time();
                            $logger->request_url = 'user/login';
                            $logger->request_data = json_encode(array('loginAttempts'=>$session->get('loginAttempts') || 0, 'remember'=>$remember, 'fromCookie'=>$fromCookie));
                            $logger->save();
                        }

                        if($this->checkBruteforce){
                            $cookie->remove('userAttemptsAuth');
                            $session->remove('loginAttempts');
                        }
                        return true;
                    }
                }
            }else{
                $this->view->errorMessage = My::t('app', 'Wrong password.');
                $this->view->errorField = 'password';
                $this->view->username = $username;
                $this->view->password = '';
            }
        }
        return false;
    }
}