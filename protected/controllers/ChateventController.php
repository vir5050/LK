<?php

/**
 * ChateventController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */
class ChateventController extends CController
{
	/**
	 * Class default constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Chatevent reward action handler
	 */
	public function rewardAction()
	{
		$request = My::app()->getRequest();
		$event = CConfig::get('chatevent');
		$secure = $request->getQuery('secure', 'alphanumeric');

		if (empty($secure) OR $secure !== $event['secure_key']) exit;

		$role = $request->getQuery('role', 'int');
		$money = $request->getQuery('money', 'int', 0);
		$gold = $request->getQuery('gold', 'int', 0);
		$item = $request->getQuery('item', 'int', 0);
		$count = $request->getQuery('item_count', 'int', 0);

		if (empty($money) AND empty($gold) AND empty($item)) exit;

		if (!empty($role)) {
			/** @var CCurl $curl */
			$curl = My::app()->getCurl();
			$result = $curl->run(CConfig::get('api').'role/rid2uid', ['roleid'=>$role])->getData(true);
			if ($result['status'] == 1 AND !empty($result['data']['userid'])) {
				$user = User::model()->findByAttributes(['user_id'=>$result['data']['userid']]);
				if ($user!==null) {

					if (!empty($money)) {
						$user->coins = (int)$user->coins + $money;
						$user->save();
					}

					if (!empty($gold)) {
						$result = $curl->run($this->api.'user/cubigold', [
							'id'=>$user->user_id,
							'count'=>$gold
						])->getData(true);
					}

					if (!empty($item) AND !empty($count)) {
						$notice = new Notice;
						$notice->account_id = $user->id;
						$notice->title = My::t('app', 'New item');
						$notice->message = My::t('app', 'Chat Event Award');
						$notice->obtain_date = time();
						$notice->notice_data = json_encode([
							'type'=>'store',
							'store_id'=>$item,
							'item_count'=>$count
						]);
						$notice->save();
					}
				}
			}
		}

	}
}