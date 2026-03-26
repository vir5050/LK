<?php
/**
 * ServerController
 *
 * PUBLIC:                PRIVATE
 * -----------            ------------------
 * __construct
 *
 */

class ServerController extends CController
{
	/** @var int */
	public $error = 1;
	/** @var int */
	public $status = 0;
	/** @var array */
	public $data = [];

	const CHATBROADCAST = 0x78;
	const DBBATTLELOAD = 0x35F;
	const GETFACTIONINFO = 0x11FE;
	const AUCTIONOPEN = 0x320;
	const SYSSENDMAIL = 0x1076;
	const GMLISTONLINEUSER = 0x160;
	const GMGETGAMEATTRI = 0x178;
	const GMSETGAMEATTRI = 0x179;

	public static $attributes = [
		'NoSellPoint' =>0xD6,
		'DoubleSP'    =>0xD5,
		'DoubleObject'=>0xD4,
		'DoubleMoney' =>0xD3,
		'NoFaction'   =>0xD2,
		'NoMail'      =>0xD1,
		'NoAuction'   =>0xD0,
		'NoTrade'     =>0xCF,
		'GetLambda'   =>0xCD,
		'DoubleExp'   =>0xCC,
		'DoubleEp'    =>0xCC

	];

	/**
	 * Class default constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Server sendMail action handler
	 */
	public function sendMailAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		/** @var CProtocol $protocol */
		$protocol = My::app()->getProtocol();
		$structure = $protocol->loadStructure(CConfig::get('server.version'));

		$receiver = $request->getPost('receiver', 'integer');
		$title = $request->getPost('title', 'string', 'MyWeb');
		$context = $request->getPost('context');
		$attach_obj = json_decode($request->getPost('attach_obj'), true);
		$attach_money = $request->getPost('attach_money', 'integer', 0);
		if(!empty($receiver)){
			$protocol->connect2delivery();
			$result = $protocol->write(0x1076, [
					'tid'=>rand(9999, 99999),
					'sysid'=>32,
					'sys_type'=>3,
					'receiver'=>$receiver,
					'title'=>$title,
					'context'=>$context,
					'attach_obj'=>$attach_obj,
					'attach_money'=>$attach_money
				],
				$structure['SysSendMail'], true)->read([
				'retcode'=>'short',
				'tid'=>'int',
			]);

			$this->error = 0;
			$this->status = 1;
			$this->data = $result['retcode'];
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
	 * Server info action handler
	 */
	public function infoAction()
	{
		/** @var CSsh2 $ssh */
		$ssh = My::app()->getSSH();
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$services = $request->getPost('services');

		$protocol = My::app()->getProtocol();
		foreach(self::$attributes as $attribute=>$value){
			$protocol->connect2delivery();
			$result = $protocol->write(self::GMGETGAMEATTRI, [
				'retcode'=>-1,
				'gmroleid'=>-1,
				'localsid'=>-1,
				'attribute'=>$value
			],[
				'retcode'=>'int',
				'gmroleid'=>'int64',
				'localsid'=>'int',
				'attribute'=>'byte'
			], true)->read([
				'max'=>'int',
				'unk1'=>'byte',
				'attribute'=>'byte',
			]);

			$this->data['attributes'][$attribute] = $result['attribute'];
		}

		$cpuLoad = $ssh->exec('top -bn1 | grep "Cpu(s)" | \
		   sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | \
		   awk \'{print 100 - $1}\'');

		$this->data['cpu'] = str_replace("\n", '', $cpuLoad);

		$memory = $ssh->exec('free -m');
		$memory = explode("\n", $memory);
		$memory = str_replace('Mem:', ' ', $memory[1]);
		$memory = explode(' ', preg_replace('/\s{2,}/', ' ', trim($memory)));
		if(count($memory) > 0){
			$this->data['memory']['total'] = $memory[0];
			$this->data['memory']['used'] = $memory[1];
			$this->data['memory']['free'] = $memory[2];
			$this->data['memory']['shared'] = $memory[3];
			$this->data['memory']['buffers'] = $memory[4];
			$this->data['memory']['cached'] = $memory[5];
		}

		$services = json_decode($services, true);
		if($services===null){
			$services = ['authd', 'gamedbd', 'gacd', 'gfactiond', 'gdeliveryd', 'glinkd', 'logservice', 'uniquenamed'];
		}

		foreach($services as $service){
			if($service !== 'authd'){
				$result = $ssh->exec('pidof '.$service);
				$pid = str_replace("\n", '', $result);
				$this->data['services'][$service]['pid'] = $pid;

				if(preg_match('/^[0-9]+$/', $pid)){
					$top = $ssh->exec('top -b -n 1 -p '.$pid.' | sed -n \'7,8p;8q\'');
					$top = explode("\n", $top);
					$top = explode(' ', preg_replace('/\s{2,}/', ' ', trim($top[1])));

					$this->data['services'][$service]['virt'] = $top[4];
					$this->data['services'][$service]['cpu'] = $top[8];
					$this->data['services'][$service]['mem'] = $top[9];
				}elseif($service == 'glinkd' and !empty($pid)){
					unset($this->data['services']['glinkd']);
					$glinkd = explode(' ', $pid);
					for($i = 0; $i < count($glinkd); $i++){
						$this->data['services']['glinkd'.($i + 1)]['pid'] = $glinkd[$i];

						$top = $ssh->exec('top -b -n 1 -p '.$glinkd[$i].' | sed -n \'7,8p;8q\'');
						$top = explode("\n", $top);
						$top = explode(' ', preg_replace('/\s{2,}/', ' ', trim($top[1])));

						$this->data['services']['glinkd'.($i + 1)]['virt'] = $top[4];
						$this->data['services']['glinkd'.($i + 1)]['cpu'] = $top[8];
						$this->data['services']['glinkd'.($i + 1)]['mem'] = $top[9];
					}
				}
			}
		}

		$processes = $ssh->exec('ps -A w');
		$lines = explode("\n", $processes);
		foreach($lines as $line){
			if(false !== $pos = strpos($line, './gs')){
				$pid = str_replace(' ', '', substr($line, 0, 5));
				$dungeon = substr($line, $pos);

				$this->data['dungeon'][$dungeon]['pid'] = $pid;

				if(preg_match('/^[0-9]+$/', $pid)){
					$top = $ssh->exec('top -b -n 1 -p '.$pid.' | sed -n \'7,8p;8q\'');
					$top = explode("\n", $top);
					$top = explode(' ', preg_replace('/\s{2,}/', ' ', trim($top[1])));

					$this->data['dungeon'][$dungeon]['virt'] = $top[4];
					$this->data['dungeon'][$dungeon]['cpu'] = $top[8];
					$this->data['dungeon'][$dungeon]['mem'] = $top[9];
				}
			}
			if(false !== $pos = strpos($line, './authd.sh')){
				$pid = str_replace(' ', '', substr($line, 0, 5));
				$this->data['services']['authd']['pid'] = $pid;

				if(preg_match('/^[0-9]+$/', $pid)){
					$top = $ssh->exec('top -b -n 1 -p '.$pid.' | sed -n \'7,8p;8q\'');
					$top = explode("\n", $top);
					$top = explode(' ', preg_replace('/\s{2,}/', ' ', trim($top[1])));

					$this->data['services']['authd']['virt'] = $top[4];
					$this->data['services']['authd']['cpu'] = $top[8];
					$this->data['services']['authd']['mem'] = $top[9];
				}
			}
		}

		$this->view->renderJson([
			'data'=>$this->data
		]);
	}

	/**
	 * Server control action handler
	 */
	public function controlAction()
	{
		/** @var CSsh2 $ssh */
		$ssh = My::app()->getSSH();
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		if($request->isPostExists('service')){
			$service = $request->getPost('service');
			if(!empty($service)){
				$ssh->exec('cd '.CConfig::get('server.path').'/'.$service.'; ./'.$service.' '.($service=='logservice' ? 'logservice.conf' : 'gamesys.conf').' > '.CConfig::get('server.startingLogsPath').''.$service.'.log &');
			}
		}

		if($request->isPostExists('dungeon')){
			$dungeon = $request->getPost('dungeon');
			if(!empty($dungeon)){
				$ssh->exec('cd '.CConfig::get('server.path').'/gamed; ./gs '.$dungeon.' &');
			}
		}

		if($request->isPostExists('pid')){
			$pid = $request->getPost('pid');
			if(!empty($pid)){
				$ssh->exec('kill '.$pid);
			}
		}
	}

	/**
	 * Server setAttribute action handler
	 */
	public function setAttributeAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$attribute = $request->getPost('attribute');
		$value = $request->getPost('value');
		if(!empty($attribute) and array_key_exists($attribute, self::$attributes)){
			/** @var CProtocol $protocol */
			$protocol = My::app()->getProtocol();
			$protocol->connect2delivery();
			$result = $protocol->write(self::GMSETGAMEATTRI, [
				'retcode'=>-1,
				'gmroleid'=>-1,
				'localsid'=>-1,
				'attribute'=>self::$attributes[$attribute],
				'value'=>(($attribute == 'DoubleExp') ? dechex($value) : bin2hex(pack('C', $value))),
				'value'=>(($attribute == 'DoubleEp') ? dechex($value) : bin2hex(pack('C', $value))),
			],
			[
				'retcode'=>'int',
				'gmroleid'=>'int64',
				'localsid'=>'int',
				'attribute'=>'byte',
				'value'=>'octets',
			], true)->read([
				'max'=>'int',
				'retcode'=>'int',
			]);

			if($result['retcode'] == 0){
				$this->error = 0;
				$this->status = 1;
			}
		}

		$this->view->renderJson([
			'error'=>$this->error,
			'status'=>$this->status,
			'data'=>$_POST['value'],
		]);
	}

	/**
	 * Server chatbroadcast action handler
	 */
	public function chatbroadcastAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$channel = $request->getPost('channel', 'integer', 9);
		$emotion = $request->getPost('emotion', 'integer', 0);
		$srcroleid = $request->getPost('srcroleid', 'integer', 0);
		$srcrolename = $request->getPost('srcrolename');
		$msg = $request->getPost('msg', '', '123');
		if($channel !== '' and !empty($msg)){
			/** @var CProtocol $protocol */
			$protocol = My::app()->getProtocol();
			$protocol->connect2provider();
			if($srcroleid != 0 and CConfig::get('server.version') == 'pw.07'){
				$protocol->write(self::CHATBROADCAST, ['channel'=>$channel, 'emotion'=>$emotion, 'srcroleid'=>0, 'msg'=>'Отправлено через MyWeb (Не ГМ)', 'data'=>''], ['channel'=>'byte', 'emotion'=>'byte', 'srcroleid'=>'int', 'msg'=>'string', 'data'=>'octets']);
				$protocol->write(self::CHATBROADCAST, ['channel'=>$channel, 'emotion'=>$emotion, 'srcroleid'=>0, 'msg'=>'Игрок '.$srcrolename.':', 'data'=>''], ['channel'=>'byte', 'emotion'=>'byte', 'srcroleid'=>'int', 'msg'=>'string', 'data'=>'octets']);
				$protocol->write(self::CHATBROADCAST, ['channel'=>$channel, 'emotion'=>$emotion, 'srcroleid'=>0, 'msg'=>$msg, 'data'=>''], ['channel'=>'byte', 'emotion'=>'byte', 'srcroleid'=>'int', 'msg'=>'string', 'data'=>'octets']);
				$result = 1;
			}else{
				$protocol->write(self::CHATBROADCAST, ['channel'=>$channel, 'emotion'=>$emotion, 'srcroleid'=>$srcroleid, 'msg'=>$msg, 'data'=>''], ['channel'=>'byte', 'emotion'=>'byte', 'srcroleid'=>'int', 'msg'=>'string', 'data'=>'octets']);
				$result = 1;
			}
		}

		if(isset($result)){
			$this->error = 0;
			$this->status = 1;
		}else{
			$this->error = 2;
		}

		$this->view->renderJson([
			'error'=>$this->error,
			'status'=>$this->status
		]);
	}

	/**
	 * Server online action handler
	 */
	public function onlineAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		$what = $request->getPost('what');
		switch($what){
			case 'all':
				$online = [];
				$users = Point::model()->findAll('zoneid = :zoneid', ['zoneid'=>CConfig::get('server.zoneid')]);
				foreach($users as $key=>$user){
					$online[$key] = $user['uid'];
				}
				break;
			case 'list':
				$online = [];
				$list = $request->getPost('list');
				$list = json_decode($list, true);
				if (!empty($list)) {
					foreach($list as $id){
						$point = Point::model()->findByAttributes(['uid'=>$id]);
						$online[$id] = ($point!==null) ? $point->zoneid : null;
					}
				}
				break;
			case 'roles':
				$id = 0;
				$online = [];
				$protocol = My::app()->getProtocol();
				$structure = $protocol->loadStructure(CConfig::get('server.version'));
				while(true){
					$protocol->connect2delivery();
					$result = $protocol->write(self::GMLISTONLINEUSER, [
						'gmroleid'=>-1,
						'localsid'=>1,
						'handler'=>$id,
						'cond'=>1
					],[
						'gmroleid'=>'int64',
						'localsid'=>'int',
						'handler'=>'int',
						'cond'=>'octets'
					], true)->read([
						'retcode'=>'int',
						'gmroleid'=>'int64',
						'localsid'=>'int',
						'handler'=>'int',
						'userlist_count'=>'vector',
						'userlist'=>$structure['GMPlayerInfo']
					]);

					if(isset($result['userlist']) and count($result['userlist']) > 0){
						foreach($result['userlist'] as $key=>$value){
							$user = User::info($value['userid']);
							if(isset($user['login_time']) and isset($user['login_ip'])){
								$result['userlist'][$key]['login_time'] = $user['login_time'];
								$result['userlist'][$key]['login_ip'] = $user['login_ip'];
							}

							set_time_limit(30);
						}
						$online = array_merge($online, $result['userlist']);
						$id = $this->_max($result['userlist'], $result['userlist'][0]['userid']);
					} else break;
					set_time_limit(30);
				}
				break;
			default:
				$online = Point::model()->countByAttributes(['zoneid'=>CConfig::get('server.zoneid')]);
		}

		$this->view->renderJson([
			'error'=>0,
			'status'=>1,
			'data'=>$online
		]);
	}
}