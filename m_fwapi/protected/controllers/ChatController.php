<?php
/**
 * ChatController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 *
 */

class ChatController extends CController
{
	/** @var int */
	public $error = 1;
	/** @var int */
	public $status = 0;
	/** @var array */
	public $data = [];
	/**
	 * Class default constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
     * Controller default action handler
     */
	public function indexAction()
	{
		/** @var CHttpRequest $request */
		$request = My::app()->getRequest();
		
		$chat = Chat::model()->findAll(['order'=>'id DESC', 'limit'=>100]);

		$this->view->renderJson($chat);
	}

	/**
	 * Chat parse action handler
	 */
	public function parseAction()
	{
		set_time_limit(60);
		ini_set('memory_limit', '512M');
		
		$db = CDatabase::init();
		$chatFile = CConfig::get('server.chat_file');

		$ssh = My::app()->getSSH();

		$chat = $ssh->exec('tail -n 1000 '.$chatFile);
		$chat = explode("\n", $chat);
		foreach ($chat as $i => $line){
			$buffer = explode(' ', $line);
			if(isset($buffer[6]) and isset($buffer[7])){
				$src = str_replace('src=', '', $buffer[7]);
				$date = strtotime($buffer[0].' '.$buffer[1]);
				if(!$db->select('SELECT id FROM mw_chat WHERE src = :src AND date = :date', [':src'=>$src, ':date'=>$date], PDO::FETCH_COLUMN)){
					if($buffer[6] == 'Chat:'){
						$channel = str_replace('chl=', '', $buffer[8]);
					}elseif($buffer[6] == 'Whisper:'){
						$channel = 4;
						$dst = str_replace('dst=', '', $buffer[8]);
					}elseif($buffer[6] == 'Guild:'){
						$channel = 3;
						$dst = str_replace('fid=', '', $buffer[8]);
					}

					if(isset($channel) AND in_array($channel, [0,1,3,4])){
						$message = base64_decode(str_replace('msg=', '', $buffer[9]));
						$message = mb_convert_encoding($message, 'UTF-8', 'UTF-16LE');
						$message = str_replace('', '', $message);
						$message = str_replace('', '', $message);
						$message = str_replace('', '', $message);
						if(!empty($message)){
							if($src != -1){
								$srcInfo = Rolelist::model()->findByPk($src);
								if(!$srcInfo){
									$role = Role::GetRole($src);
									$srcInfo = new Rolelist;
									$srcInfo->id = $src;
									$srcInfo->name = $role['base']['name'];
									$srcInfo->save();
									unset($role);
								}

								$srcName = $srcInfo->name;
								unset($srcInfo);
							}
							if(!empty($dst)){
								if ($channel == 3) {
									$dstInfo = Faction::model()->findByPk($dst);
									if(!$dstInfo){
										$faction = Faction::info($dst);
										$dstInfo = new Faction;
										$dstInfo->id = $dst;
										$dstInfo->name = $faction['name'];
										$dstInfo->level = $faction['level'];
										$dstInfo->master = $faction['master'];
										$dstInfo->members = count($faction['member']);
										$dstInfo->save();
										unset($faction);
									}
									
									$dstName = $dstInfo->name;
									unset($dstInfo);
								} else {
									$dstInfo = Rolelist::model()->findByPk($dst);
									if(!$dstInfo){
										$dstRole = Role::GetRole($dst);
										$dstInfo = new Rolelist;
										$dstInfo->id = $dst;
										$dstInfo->name = $dstRole['base']['name'];
										$dstInfo->save();
										unset($dstRole);
									}
									
									$dstName = $dstInfo->name;
									unset($dstInfo);
								}
							}

							$db->insert('mw_chat', [
								'src'=>$src,
								'src_name'=>$srcName,
								'msg'=>$message,
								'dst'=>(!empty($dst) ? $dst : 0),
								'dst_name'=>(!empty($dst) ? $dstName : ''),
								'date'=>$date,
								'channel'=>$channel,
							]);

							unset($src);
							unset($message);
							unset($dst);
							unset($channel);
							unset($date);
						}
					}
				}
			}
		}
	}
}