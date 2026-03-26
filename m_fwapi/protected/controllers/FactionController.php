<?php

/**
 * FactionController
 *
 * PUBLIC:                PRIVATE
 * -----------            ------------------
 * __construct
 * indexAction
 *
 */
class FactionController extends CController
{
	/** @var int */
	public $error = 1;
	/** @var int */
	public $status = 0;
	/** @var array */
	public $data = [];

	const DBTERRITORYLISTLOAD = 0x429;
	const GETFACTIONINFO = 0x11FC;

	/**
	 * Class default constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Faction info action handler
	 */
	public function infoAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$factionId = $request->getRequest('factionId', 'integer', 22);
		if(!empty($factionId)){
			/** @var CProtocol $protocol */
			$protocol = My::app()->getProtocol();
			$version = CConfig::get('server.version');
			$protocol->connect2gamedbd();
			$structure = $protocol->loadStructure($version);
			$protocol->write(self::GETFACTIONINFO, [
				'retcode'=>-1,
				'factionid'=>$factionId
			], [
				'retcode'=>'int',
				'factionid'=>'int'
			]);
			$result = $protocol->read([
				'max'=>'int',
				'retcode'=>'int',
				'cachesize'=>'int',
				'FactionInfo'=>$structure['FactionInfo']
			]);
			$factionInfo = $result['FactionInfo'];
		}

		if(isset($factionInfo) and !empty($factionInfo['fid'])){
			$this->error = 0;
			$this->status = 1;
			$this->data = $factionInfo;
		}else{
			$this->error = 2;
		}

		$this->view->renderJson([
			'error'=>$this->error,
			'status'=>$this->status,
			'data'=>$this->data
		]);
	}

	/**
	 * Faction update action handler
	 */
	public function updateAction()
	{
		/*$protocol = My::app()->getProtocol();
		$structure = $protocol->loadStructure(CConfig::get('server.version'));
		$protocol->connect2gamedbd();
		$result = $protocol->write(self::DBTERRITORYLISTLOAD, [
			'retcode'=>-1,
			'default_ids'=>0
		], [
			'retcode'=>'int',
			'default_ids'=>'int'
		])->read([
			'max'=>'int',
			'retcode'=>'int',
			'store'=>[
				'status'=>'int',
				'tlist_count'=>'vector',
				'tlist'=>$structure['TerritoryDetail'],
				'reserved1'=>'int',
				'reserved2'=>'int',
				'reserved3'=>'int',
				'reserved4'=>'int'
			]
		]);

		$this->view->renderJson($result);*/

		$protocol = My::app()->getProtocol();
		$structure = $protocol->loadStructure(CConfig::get('server.version'));

		foreach (range(1, 100) as $id) {
			$protocol->connect2gamedbd();

			$result = $protocol->write(self::GETFACTIONINFO, [
				'retcode'=>-1,
				'factionid'=>$id
			], [
				'retcode'=>'int',
				'factionid'=>'int'
			])->read([
				'max'=>'int',
				'retcode'=>'int',
				'cachesize'=>'int',
				'data'=>$structure['FactionInfo']
			]);

			$faction = $result['data'];
			if (!empty($faction['fid'])) {
				$model = Faction::model()->findByPk($faction['fid']);
				if ($model==null) {
					$model = new Faction;
					$model->id = $faction['fid'];
				}
				$model->name = $faction['name'];
				$model->level = $faction['level'];
				$model->master = $faction['master'];
				$model->prosperity = $faction['prosperity'];
				$model->nimbus = $faction['contribution'];
				$model->contribution = $faction['nimbus'];
				$model->members = count($faction['member']);
                if (!$model->save()) {
                	echo CDatabase::getErrorMessage()."\n";
                }
			}
		}
	}
}