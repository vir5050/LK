<?php
/**
* AdminController
*
* PUBLIC:				  	PRIVATE
* -----------			  	------------------
* __construct
*
*/
class AdminController extends CController
{
	/**	@var string */
	private $apiUrl;

	public function __construct()
	{
		parent::__construct();

		if(!CAuth::isLoggedInAsAdmin()){
			$this->redirect('index/index');
		}

		$this->view->actionMessage = '';

		$this->apiUrl = CConfig::get('apiUrl');
	}

	/**
	 * Controller default action handler
	 */
	public function indexAction()
	{
		//$this->redirect('admin/dashboard');
	}

	/**
	 * Admin settings action handler
	 */
	public function settingsAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var Settings $settings */
		$settings = Settings::model()->findByPk(1);

		if($request->getPost('act') == 'save'){
			$key = $request->getPost('key');
			$value = $request->getPost('value');
			if(array_key_exists($key, $settings->getFieldsAsArray())){
				if($key == 'smtp_password' and $value != ''){
					$value = CHash::encrypt($value, CConfig::get('installationKey'));
				}
				$settings->$key = $value;
				if($settings->save()){
					$message = My::t('app', 'Changes saved');
					$messageType = 'success';
				}else{
					$message = My::t('app', 'Failed');
					$messageType = 'error';
				}
			}else{
				$message = My::t('app', 'Failed');
				$messageType = 'warning';
			}
		}

		if(isset($message) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message, array('style'=>'margin-bottom: 0px;')));
		}

		$this->view->mailersList = array(
			'phpMail'=>'phpMail',
			'phpMailer'=>'phpMailer',
			'smtpMailer'=>'smtpMailer'
		);
		$this->view->simpleEnum = array(
			'0'=>My::t('app', 'No'),
			'1'=>My::t('app', 'Yes')
		);
		$this->view->smtp_secureList = array(
			''=>'',
			'ssl'=>'SSL',
			'tls'=>'TLS'
		);
		$this->view->settings = $settings;
		$this->view->setMetaTags('title', My::t('app', 'Main Settings'));
		$this->view->render('admin/settings', $request->isAjaxRequest());
	}

	/**
	 * Admin services action handler
	 */
	public function servicesAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->getPost('act') == 'save'){
			$serviceId = $request->getPost('service');
			$enable = $request->getPost('enable', 'integer', 0);
			$price = $request->getPost('price', 'integer', 0);

			$service = ServiceSettings::model()->findByAttributes(array('service_id'=>$serviceId));
			if($service !== null){
				$service->enable = $enable;
				$service->price = $price;
				if($request->isPostExists('max')){
					$service->max = $request->getPost('max');
				}
				if($request->isPostExists('value')){
					$service->value = $request->getPost('value');
				}

				if($service->save()){
					$message = My::t('app', 'Changes saved');
					$messageType = 'success';
				}else{
					$message = My::t('app', 'Failed');
					$messageType = 'error';
				}
			}else{
				$message = My::t('app', 'Failed');
				$messageType = 'warning';
			}
		}

		if(isset($message) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message, array('style'=>'margin-bottom: 0px;')));
		}

		$this->view->simpleEnum = array(
			'0'=>My::t('app', 'No'),
			'1'=>My::t('app', 'Yes')
		);
		$this->view->services = ServiceSettings::model()->findAll(array('order'=>'id ASC'));
		$this->view->setMetaTags('title', My::t('app', 'Services Settings'));
		$this->view->render('admin/services', $request->isAjaxRequest());
	}

	/**
	 * Admin mmotop action handler
	 */
	public function mmotopAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var MmotopSettings $settings */
		$settings = MmotopSettings::model()->findByPk(1);

		if($request->getPost('act') == 'save'){
			$key = $request->getPost('key');
			$value = $request->getPost('value');
			if(array_key_exists($key, $settings->getFieldsAsArray())){
				$settings->$key = $value;
				if($settings->save()){
					$message = My::t('app', 'Changes saved');
					$messageType = 'success';
				}else{
					$message = My::t('app', 'Failed');
					$messageType = 'error';
				}
			}else{
				$message = My::t('app', 'Failed');
				$messageType = 'warning';
			}
		}

		if(isset($message) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message, array('style'=>'margin-bottom: 0px;')));
		}

		$this->view->simpleEnum = array(
			'0'=>My::t('app', 'No'),
			'1'=>My::t('app', 'Yes')
		);
		$this->view->settings = $settings;
		$this->view->setMetaTags('title', My::t('app', 'MMOTOP Settings'));
		$this->view->render('admin/mmotop', $request->isAjaxRequest());
	}

	/**
	 * Admin roleedit action handler
	 */
	public function roleeditAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var CCurl $curl */
		$curl = My::app()->getCurl();
		$roleId = $request->getQuery('id');

		if($request->getPost('act') == 'save' and $roleId != ''){
			if(APP_MODE == 'demo'){
				$message = My::t('core', 'Blocked in Demo Mode.');
				$messageType = 'warning';
			}else{
				$roleData = $request->getPost('roleData');
				if(!empty($roleData)){
					$result = $curl->run($this->apiUrl.'role/put', array(
						'roleid'=>$roleId,
						'value'=>$roleData
					))->getData(true);

					if($result['status'] == 1){
						$message = My::t('app', 'Changes saved');
						$messageType = 'success';
					}else{
						$message = My::t('app', 'Failed');
						$messageType = 'error';
					}
				}else{
					$message = My::t('app', 'Failed');
					$messageType = 'warning';
				}
			}
		}

		if(!empty($roleId)){
			$result = $curl->run($this->apiUrl.'role/get', array(
				'roleid'=>$roleId,
			))->getData(true);

			if($result['status'] == 1){
				$role = $result['data']['role'];
			}else{
				$message = My::t('app', 'Failed');
				$messageType = 'warning';
			}
		}

		if(isset($message) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message, array('style'=>'margin-bottom: 0px;')));
		}

		$this->view->simpleEnum = array(
		);
		$this->view->roleId = $roleId;
		$this->view->roleData = isset($role) ? $role : null;
		$this->view->setMetaTags('title', My::t('app', 'Character editor'));
		$this->view->render('admin/roleedit', $request->isAjaxRequest());
	}

	/**
	 * Admin userinfo action handler
	 */
	public function userinfoAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$id = $request->getQuery('id');
		if(!empty($id)){
			if(CValidator::isInteger($id)){
				/** @var User $user */
				$user = User::model()->findByPk($id);
			}elseif(CValidator::isMixed($id)){
				/** @var User $user */
				$user = User::model()->findByAttributes(array('username'=>$id));
			}

			if(isset($user)){
				$this->view->lastLogin = Logger::model()->findByAttributes(array('account_id'=>$user->id, 'request_url'=>'user/login'), array('order'=>'request_date DESC'));
				$result = My::app()->getCurl()->run(CConfig::get('apiUrl').'user/info', array(
					'userid'=>$user->user_id
				))->getData(true);

				if($result['status'] == 1){
					$this->view->userInfo = $result['data'];
				}

				$result = My::app()->getCurl()->run(CConfig::get('apiUrl').'user/roles', array(
					'userid'=>$user->user_id
				))->getData(true);

				if($result['status'] == 1){
					$this->view->userRoles = $result['data'];
				}
			}else{
				$message = My::t('app', 'User not found.');
				$messageType = 'error';
			}
		}else{
			$this->view->targetPath = 'admin/userinfo';
			$this->view->pageSize = 20;
			$this->view->currentPage = $request->getQuery('page', 'integer', 1);
			$this->view->totalRecords = User::model()->count();
			$this->view->users = User::model()->findAll(array('limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'register_date ASC'));
		}

		if($request->getPost('act') == 'save' and isset($user)){
			if(APP_MODE == 'demo'){
				$message = My::t('core', 'Blocked in Demo Mode.');
				$messageType = 'warning';
			}else{
				$key = $request->getPost('key');
				$value = $request->getPost('value');
				if(array_key_exists($key, $user->getFieldsAsArray())){
					if($key == 'password'){
                        if($settings->lower_passwd) $value = strtolower($value);
						$value = CHash::salt(CConfig::get('password.encryptAlgorithm'), $user->username, $value);
                        My::app()->getCurl()->run($this->apiUrl.'user/update', array(
                            'ID'=>$user->user_id,
                            'params'=>json_encode(array(
                                'passwd'=>$value,
                                'passwd2'=>$value
                            ))
                        ))->getData(true);
                    }
					if($key == 'auth_ip'){
						$value = CIp::convertIpStringToBinary($value);
					}

					$user->$key = $value;
					if($user->save()){
						$message = My::t('app', 'Changes saved');
						$messageType = 'success';
					}else{
						$message = My::t('app', 'Failed');
						$messageType = 'error';
					}
				}else{
					$message = My::t('app', 'Failed');
					$messageType = 'warning';
				}
			}

		}

		if(isset($message) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message, array('style'=>'margin-bottom: 0px;')));
		}

		$this->view->simpleEnum = array(
			'0'=>My::t('app', 'No'),
			'1'=>My::t('app', 'Yes')
		);
		$this->view->languageList = array(
			'ru'=>My::t('i18n', 'languages.ru'),
			'en'=>My::t('i18n', 'languages.en')
		);
		$this->view->rolesList = array(
			'owner'=>My::t('app', 'Администратор'),
			'admin'=>My::t('app', 'Администратор'),
			'member'=>My::t('app', 'Пользователь')
		);
		$this->view->id = $id;
		$this->view->user = isset($user) ? $user : null;
		$this->view->setMetaTags('title', My::t('app', 'User info'));
		$this->view->render('admin/userinfo', $request->isAjaxRequest());
	}

	/**
	 * Admin servermanagement action handler
	 */
	public function servermanagementAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var CCurl $curl */
		$curl = My::app()->getCurl();

		if($request->isPostExists('startDungeon')){
			if(APP_MODE == 'debug' or APP_MODE == 'production'){
				$dungeon = $request->getPost('startDungeon');
				$curl->run($this->apiUrl.'server/control', array(
					'dungeon'=>$dungeon
				));
			}
		}

		if($request->isPostExists('startService')){
			if(APP_MODE == 'debug' or APP_MODE == 'production'){
				$service = $request->getPost('startService');
				$curl->run($this->apiUrl.'server/control', array(
					'service'=>$service
				));
			}
		}

		if($request->isPostExists('killProcess')){
			if(APP_MODE == 'debug' or APP_MODE == 'production'){
				$pid = $request->getPost('killProcess');
				$curl->run($this->apiUrl.'server/control', array(
					'pid'=>$pid
				));
			}
		}

		if($request->isPostExists('attri') and $request->isPostExists('value')){
			if(APP_MODE == 'debug' or APP_MODE == 'production'){
				$attribute = $request->getPost('attri');
				$value = $request->getPost('value');
				$curl->run($this->apiUrl.'server/setAttribute', array(
					'attribute'=>$attribute,
					'value'=>$value
				));
			}
		}

		$cache = CCache::getContent(md5('server|info').'.cch', 60);
		if(!$cache or $request->isPostExists('updServices')){
			$result = $curl->run($this->apiUrl.'server/info', array(
				'services'=>json_encode(CConfig::get('admin.monitoring.services'))
			))->getData(true);

			if(!empty($result)){
				CCache::setContent($result);
			}
		}else{
			$result = $cache;
		}

		$expList = array();
		foreach(range(10, 100, 5) as $key){
			$expList[$key] = $key / 10;
		}

		$this->view->monitoring = $result['data'];
		$this->view->lastUpdate = round((time() - CCache::getFileLifetime()) / 60).' '.My::t('i18n', 'time.abbreviated.minutes').' '.My::t('core', 'ago');
		$this->view->expList = $expList;
		$this->view->setMetaTags('title', My::t('app', 'Server management'));
		$this->view->render('admin/servermanagement', $request->isAjaxRequest());
		
		$epList = array();
		foreach(range(10, 100, 5) as $key){
			$epList[$key] = $key / 10;
		}

		$this->view->monitoring = $result['data'];
		$this->view->lastUpdate = round((time() - CCache::getFileLifetime()) / 60).' '.My::t('i18n', 'time.abbreviated.minutes').' '.My::t('core', 'ago');
		$this->view->epList = $epList;
		$this->view->setMetaTags('title', My::t('app', 'Server management'));
		$this->view->render('admin/servermanagement', $request->isAjaxRequest());
	}

	/**
	 * Admin sendmail action handler
	 */
	public function sendmailAction()
	{
		/** @var CCurl $curl */
		$curl = My::app()->getCurl();
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->getPost('act') == 'send'){
			if(APP_MODE == 'demo'){
				$message = My::t('core', 'Blocked in Demo Mode.');
				$messageType = 'warning';
			}else{
				$receiver = $request->getPost('receiver');
				$title = $request->getPost('title');
				$context = $request->getPost('context');
				$item_id = $request->getPost('item_id');
				$count = $request->getPost('count', 'integer', 1);
				$max_count = $request->getPost('max_count', 'integer', 1);
				$octet = $request->getPost('octet', 'string', '');
				$proctype = $request->getPost('proctype', 'integer', 0);
				$expire_date = $request->getPost('expire_date', 'integer', 0);
				$mask = $request->getPost('mask', 'integer', 0);

				$sendType = $request->getPost('sendtype');
				if($sendType == 'listed' and !empty($receiver)){
					$receivers = explode(',', str_replace(' ', '', $receiver));
					foreach($receivers as $roleId){
						$result = $curl->run(CConfig::get('apiUrl').'server/sendMail', array(
							'receiver'=>$roleId,
							'title'=>$title,
							'context'=>$context,
							'attach_obj'=>json_encode(array(
								'id'=>$item_id,
								'pos'=>0,
								'count'=>$count,
								'client_size'=>0,
								'max_count'=>$max_count,
								'data'=>$octet,
								'proctype'=>$proctype,
								'expire_date'=>(($expire_date > 0) ? time() + $expire_date : 0),
								'guid1'=>0,
								'guid2'=>0
							)),
							'attach_money'=>0
						))->getData(true);

						if($result['status'] == 1){
							$cache = CCache::getContent(md5('roleid2uid'.$roleId).'.cch', 120);
							if(!$cache){
								$result = $curl->run(CConfig::get('apiUrl').'role/rid2uid', array(
									'roleid'=>$roleId
								))->getData(true);

								if($result['status'] == 1){
									$userId = $result['data']['userid'];
									CCache::setContent(array('roleid'=>$roleId, 'userid'=>$userId));
								}
							}else{
								$userId = $cache['userid'];
							}

							if(isset($userId)){
								$log = new StoreLog;
								$log->account_id = User::model()->findByAttributes(array('user_id'=>$userId))->id;
								$log->store_id = Store::model()->findByAttributes(array('item_id'=>$item_id))->store_id;
								$log->ip_address = CIp::getBinaryIp();
								$log->request_date = time();
								$log->request_data = json_encode(array('count'=>$count, 'total_price'=>0, 'receiver'=>$roleId));
								$log->save();
								unset($log);
							}
							$message = My::t('app', 'Successfully');
							$messageType = 'success';
						}else{
							$message = My::t('app', 'Failed');
							$messageType = 'error';
						}
						set_time_limit(30);
					}
				}elseif($sendType == 'online'){
					$result = My::app()->getCurl()->run(CConfig::get('apiUrl').'server/online', array(
						'what'=>'all'
					))->getData(true);

					if($result['status'] == 1){
						$online = $result['data'];
					}else{
						$online = null;
					}

					if(!empty($online)){
						foreach($online as $userId){
							$data = array(
								'type'=>'store',
								'store_id'=>Store::model()->findByAttributes(array('item_id'=>$item_id))->store_id,
								'item_count'=>$count,
								'item_data'=>$octet,
								'item_proctype'=>$proctype,
								'item_expire_date'=>(($expire_date > 0) ? time() + $expire_date : 0),
								'requirements'=>''
							);

							$notice = new Notice;
							$notice->account_id = User::model()->findByAttributes(array('user_id'=>$userId))->id;
							$notice->title = $title;
							$notice->message = $context;
							$notice->obtain_date = time();
							$notice->notice_data = json_encode($data);
							$notice->save();
							unset($notice);
						}
						$message = My::t('app', 'Successfully');
						$messageType = 'success';
					}else{
						$message = My::t('app', 'Failed');
						$messageType = 'error';
					}
				}elseif($sendType == 'all'){
					$users = User::model()->findAll(array('condition'=>'is_banned = :is_banned'), array(':is_banned'=>0));
					if(!empty($users)){
						foreach($users as $user){
							$data = array(
								'type'=>'store',
								'store_id'=>Store::model()->findByAttributes(array('item_id'=>$item_id))->store_id,
								'item_count'=>$count,
								'item_data'=>$octet,
								'item_proctype'=>$proctype,
								'item_expire_date'=>(($expire_date > 0) ? time() + $expire_date : 0),
								'requirements'=>''
							);

							$notice = new Notice;
							$notice->account_id = $user['id'];
							$notice->title = $title;
							$notice->message = $context;
							$notice->obtain_date = time();
							$notice->notice_data = json_encode($data);
							$notice->save();
							unset($notice);
						}
						$message = My::t('app', 'Successfully');
						$messageType = 'success';
					}else{
						$message = My::t('app', 'Failed');
						$messageType = 'error';
					}
				}else{
					$message = My::t('app', 'Failed');
					$messageType = 'warning';
				}
			}

		}

		if(isset($message) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message, array('style'=>'margin-bottom: 0px;')));
		}


		$this->view->proctypes = '';
		$itemProctype = Store::proctype();
		foreach((array)My::t('app', 'proctype') as $key => $value){
			$checked = (in_array($key, $itemProctype) ? ' checked' : '');
			$this->view->itemProctype .= '<input type="checkbox" class="checkbox" value="'.$key.'" onchange="calculateProctype();" data-st="item-proctype" id="item-proctype-id-'.$key.'"'.$checked.' />
				<label for="item-proctype-id-'.$key.'" class="icon-checkbox">'.$value.'</label>';
		}

		$this->view->sendTypesList = array(
			'listed'=>My::t('app', 'Send to listed'),
			'online'=>My::t('app', 'Send to online users'),
			'all'=>My::t('app', 'Send to all users')
		);
		$this->view->render('admin/sendmail', $request->isAjaxRequest());
	}

	/**
	 * Admin forbid action handler
	 */
	public function forbidAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->getPost('act') == 'send'){
			if(APP_MODE == 'demo'){
				$msg = My::t('core', 'Blocked in Demo Mode.');
				$messageType = 'warning';
			}else{
				$roleId = $request->getPost('roleid');
				$time = $request->getPost('time');
				$reason = $request->getPost('reason');
				$type = $request->getPost('type');
				$what = $request->getPost('what');
				if($what == 'remove'){
					$time = 0;
				}

				if($type == 'account'){
					$result = My::app()->getCurl()->run($this->apiUrl.'user/kickout', array(
						'roleid'=>$roleId,
						'time'=>$time,
						'reason'=>$reason
					))->getData(true);
				}else{
					$result = My::app()->getCurl()->run($this->apiUrl.'role/forbid', array(
						'type'=>$type,
						'roleid'=>$roleId,
						'time'=>$time,
						'reason'=>$reason
					))->getData(true);
				}

				if($result['status'] == 1){
					$msg = My::t('app', 'Successfully');
					$messageType = 'success';
				}else{
					$msg = My::t('app', 'Failed');
					$messageType = 'warning';
				}
			}

		}

		if(isset($msg) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
		}

		$this->view->forbidTypesList = array(
			100=>My::t('app', 'Forbid character'),
			101=>My::t('app', 'Forbid chat'),
			102=>My::t('app', 'Forbid trade'),
			'account'=>My::t('app', 'Forbid account')
		);
		$this->view->whatList = array(
			'ban'=>My::t('app', 'Ban'),
			'remove'=>My::t('app', 'Remove ban')
		);
		$this->view->setMetaTags('title', My::t('app', 'Forbid manager'));
		$this->view->render('admin/forbid', $request->isAjaxRequest());
	}

	/**
	 * Admin userPriv action handler
	 */
	public function userPrivAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->getPost('act') == 'send' OR $request->getQuery('removePriv') != ''){
			if(APP_MODE == 'demo'){
				$msg = My::t('core', 'Blocked in Demo Mode.');
				$messageType = 'warning';
			}else{
				$userId = $request->getPost('id');
				if (empty($userid))
					$userId = $request->getQuery('removePriv');

				$what = $request->getPost('what');

				if($what == 'add'){
					$result = My::app()->getCurl()->run($this->apiUrl.'user/addGM', array(
						'id'=>$userId
					))->getData(true);
				}else{
					$result = My::app()->getCurl()->run($this->apiUrl.'user/delUserPriv', array(
						'id'=>$userId,
						'rid'=>0,
						'deltype'=>2,
					))->getData(true);
				}

				if($result['status'] == 1){
					$msg = My::t('app', 'Successfully');
					$messageType = 'success';
				}else{
					$msg = My::t('app', 'Failed');
					$messageType = 'warning';
				}
			}
		}
		
		$GMList = My::app()->getCurl()->run($this->apiUrl.'user/GMList')->getData(true);

		if(isset($msg) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
		}
		$this->view->whatList = array(
			'add'=>My::t('app', 'Выдать права'),
			'remove'=>My::t('app', 'Удалить права')
		);
		$this->view->GMList = $GMList;
		$this->view->setMetaTags('title', My::t('app', 'Управление привилегиями'));
		$this->view->render('admin/userpriv', $request->isAjaxRequest());
	}

	/**
	 * Admin sendmessage action handler
	 */
	public function sendmessageAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->getPost('act') == 'send'){
			if(APP_MODE == 'demo'){
				$msg = My::t('core', 'Blocked in Demo Mode.');
				$messageType = 'warning';
			}else{
				$message = $request->getPost('message');
				$channel = $request->getPost('channel');
				$receiver = $request->getPost('receiver');

				if(!empty($message)){
					if($channel == 4){
						$result = My::app()->getCurl()->run($this->apiUrl.'role/private', array(
							'receiver'=>$receiver,
							'msg'=>$message,
						))->getData(true);
					}else{
						$result = My::app()->getCurl()->run($this->apiUrl.'server/chatbroadcast', array(
							'channel'=>$channel,
							'srcroleid'=>0,
							'msg'=>$message
						))->getData(true);
					}

					if($result['status'] == 1){
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
		}

		if(isset($msg) and isset($messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
		}

		$this->view->setMetaTags('title', My::t('app', 'Broadcast message'));
		$this->view->render('admin/sendmessage', $request->isAjaxRequest());
	}

	/**
	 * Admin online action handler
	 */
	public function onlineAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();

		$result = My::app()->getCurl()->run(CConfig::get('apiUrl').'server/online', array(
			'what'=>'roles'
		))->getData(true);

		if($result['status'] == 1){
			$this->view->online = $result['data'];
		}else{
			$this->view->online = '';
		}

		$this->view->setMetaTags('title', My::t('app', 'Online characters'));
		$this->view->render('admin/online', $request->isAjaxRequest());
	}

	/**
	 * Admin ingamechat action handler
	 */
	public function ingamechatAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$result = My::app()->getCurl()->run(CConfig::get('apiUrl').'server/chat')->getData(true);

		$this->view->chat = array_reverse($result['data']);
		$this->view->setMetaTags('title', My::t('app', 'Ingame chat'));
		$this->view->render('admin/ingamechat', $request->isAjaxRequest());
	}

	/**
	 * Ajax helper
	 */
	public function ajaxAction()
	{
		$this->view->response = '';

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var CCurl $curl */
		$curl = My::app()->getCurl();
		if($request->isAjaxRequest()){
			switch($request->getPost('act')){
				case 'del_char':
					if(APP_MODE == 'demo'){
						$this->view->response = My::t('core', 'Blocked in Demo Mode.');
					}else{
						$id = $request->getPost('id');
						$result = $curl->run(CConfig::get('apiUrl').'role/delete', array(
							'roleid'=>$id
						))->getData(true);

						if($result['status'] == 1){
							$this->view->response = My::t('app', 'Successfully');
						}else{
							$this->view->response = My::t('app', 'Failed');
						}
					}
					break;
                case 'clear_cache':
                    if(APP_MODE == 'demo'){
                        $this->view->response = My::t('core', 'Blocked in Demo Mode.');
                    }else{
                        CFile::emptyDirectory(CConfig::get('cache.path'));
                        $this->view->response = My::t('app', 'Successfully');
                    }
                    break;
                case 'leaderboard':
                    if(APP_MODE == 'demo'){
                        $this->view->response = My::t('core', 'Blocked in Demo Mode.');
                    }else{
                        $curl->run(CConfig::get('apiUrl').'leaderboard/updateRoles');
						CFile::emptyDirectory(CConfig::get('cache.path'));
                    }
                    break;
                case 'battleload':
                    if(APP_MODE == 'demo'){
                        $this->view->response = My::t('core', 'Blocked in Demo Mode.');
                    }else{
                        $curl->run(CConfig::get('apiUrl').'server/battleload');
						CCache::deleteCacheFile(md5('best.factions').'.cch');
                    }
                    break;
			}
		}

		$this->view->render('admin/ajax', true);
	}
}