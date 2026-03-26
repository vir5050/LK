<?php
error_reporting(0);

/**
 * PromocodeController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */
class PromocodeController extends CController
{
	public function __construct()
	{
		parent::__construct();

		CAuth::handleLogin('user/login');
		$this->view->response = '';
		$this->view->actionMessage = '';
	}

	public function indexAction()
	{
		parent::redirect('promocode/activate');
	}

	public function activateAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();

		if ($request->isPostExists('activate')) {
			$code = $request->getPost('code', 'alphanumeric');

			$promocode = Promocode::model()->findByAttributes(['code'=>$code]);
			if ($promocode!==null) {
				if ($promocode->isUsed() OR ($promocode->reusable == 1 && $promocode->isActivated())) {
				{
					echo ("<script LANGUAGE='JavaScript'>
    window.alert('Этот промокод уже активирован.');
    window.location.href='/promocode/activate';
    </script>");
				}
				} else {
					if ($promocode->activate()) {
						
						if ($promocode->store_id > 0 && $promocode->count > 0) {

							$notice = new Notice;
							$notice->account_id = CAuth::getLoggedId();
							$notice->title = My::t('app', 'New item');
							$notice->message = 'Активация промокода '.$code;
							$notice->obtain_date = time();
							$notice->notice_data = json_encode([
								'type'=>'store',
                                'store_id'=>$promocode->store_id,
                                'item_count'=>$promocode->count,
							]);

							if ($notice->save()) {
								$this->view->item = Store::model()->findByPk($promocode->store_id);
							} else {
								echo CDatabase::getErrorMessage();
							}
						}
						
						if ($promocode->coins > 0) {
							$user = User::model()->findByPk(CAuth::getLoggedId());
							$user->coins = $user->coins + $promocode->coins;
							if ($user->save()) {
								$this->view->coins = $promocode->coins;
							}
						}
						
						$this->view->render('promocode/activate', $request->isAjaxRequest());
					} else {
						echo CDatabase::getErrorMessage();
					}
				}
			}

			exit;
		}

		if(isset($msg, $messageType)){
			$this->view->actionMessage = CWidget::create('CMessage', [$messageType, $msg]);
		}

		$this->view->setMetaTags('title', My::t('app', 'Активировать промокод'));
		$this->view->render('promocode/activate', $request->isAjaxRequest());
	}

	public function adminAction()
	{
		if (!CAuth::isLoggedInAsAdmin()) parent::redirect('index/index');

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();

		if ($request->getPost('act') == 'remove') {
			if (Promocode::model()->deleteByPk($request->getPost('id', 'int'))) {
				echo 'Промокод удален';
			} else {
				echo CDatabase::getErrorMessage();
			}
			exit;
		}

		$this->view->promocodes = Promocode::model()->findAll();
		$this->view->setMetaTags('title', My::t('app', 'Управление промокодами'));
		$this->view->render('promocode/admin', $request->isAjaxRequest());
	}

	public function historyAction()
	{
		if (!CAuth::isLoggedInAsAdmin()) parent::redirect('index/index');

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var CDatabase $db */
		$db = CDatabase::init();

		$id = $request->getQuery('id', 'int');

        $this->view->targetPath = 'promocode/history';
        $this->view->pageSize = 50;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = $db->select('
            SELECT COUNT(*) as count
            FROM '.CConfig::get('db.prefix').'promocode_to_user
            WHERE promocode_id = :promocode
        ', [
            ':promocode'=>$id
        ], PDO::FETCH_COLUMN)[0];

        $this->view->promocodes = $db->select('
            SELECT p.user_id, p.activated_at, u.username
            FROM '.CConfig::get('db.prefix').'promocode_to_user p
            LEFT JOIN '.CConfig::get('db.prefix').'users u ON u.id = p.user_id
            WHERE promocode_id = :promocode
            ORDER BY activated_at DESC
            LIMIT '.(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, [':promocode'=>$id]);

		$this->view->setMetaTags('title', My::t('app', 'История'));
		$this->view->render('promocode/history', $request->isAjaxRequest());
	}

	public function addAction()
	{
		if (!CAuth::isLoggedInAsAdmin()) parent::redirect('index/index');

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();

		if ($request->getPost('act') == 'send') {
			$promocode = new Promocode;
			$promocode->code = $request->getPost('code', 'alphanumeric');
			$promocode->reusable = $request->getPost('reusable', 'int', 0);
			$promocode->store_id = $request->getPost('store_id', 'int', NULL);
			$promocode->count = $request->getPost('count', 'int', 0);
			$promocode->coins = $request->getPost('coins', 'int', 0);
			$promocode->status = $request->getPost('status', 'int', 0);
			$promocode->created_at = time();
			if ($promocode->save()) {
				echo 'Запрос успешно выполнен';
			} else {
				echo CDatabase::getErrorMessage();
			}
			exit;
		}

		$this->view->setMetaTags('title', My::t('app', 'Добавление промокода'));
		$this->view->render('promocode/add', $request->isAjaxRequest());
	}

	public function editAction()
	{
		if (!CAuth::isLoggedInAsAdmin()) parent::redirect('index/index');

		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();

		$id = $request->getQuery('id', 'int');
		$promocode = Promocode::model()->findByPk($id);

		if ($promocode==null) exit();

		if ($request->getPost('act') == 'send') {
			$promocode->code = $request->getPost('code', 'alphanumeric');
			$promocode->reusable = $request->getPost('reusable', 'int', 0);
			$promocode->store_id = $request->getPost('store_id', 'int', NULL);
			$promocode->count = $request->getPost('count', 'int', 0);
			$promocode->coins = $request->getPost('coins', 'int', 0);
			$promocode->status = $request->getPost('status', 'int', 0);
			$promocode->created_at = time();
			if ($promocode->save()) {
				$msg = My::t('app', 'Запрос успешно выполнен');
                $messageType = 'error';
			} else {
				echo CDatabase::getErrorMessage();
			}
			exit;
		}
		
        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }
		
		$this->view->promocode = $promocode;
		$this->view->setMetaTags('title', My::t('app', 'Редактирование промокода'));
		$this->view->render('promocode/edit', $request->isAjaxRequest());
	}
}