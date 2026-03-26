<?php

/**
 * IconController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */
class IconController extends CController
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
        /** @var CCurl $curl */
        $curl = My::app()->getCurl();
        $service = ServiceSettings::model()->findByAttributes(array('service_id'=>'guildicon'));
        if($service->enable == 1){
            $roleId = CAuth::getLoggedParam('selectedRoleId'); //104212
            $roleName = CAuth::getLoggedParam('selectedRoleName');
            if($roleId===null and $roleName===null){
                $msg = My::t('app', 'Character not selected');
                $messageType = 'error';
                $this->view->offline = 1;
            }else{
                $cache = CCache::getContent(md5('role'.$roleId.'faction').'.cch', 30);
                if(!$cache){
                    $result = $curl->run($this->apiUrl.'role/faction', array(
                        'roleid'=>$roleId
                    ))->getData(true);

                    if($result['status'] == 1){
                        $roleFaction = $result['data'];
                    }
                    CCache::setContent(isset($roleFaction) ? $roleFaction : 'noguild');
                }else{
                    $roleFaction = $cache;
                }

                if(isset($roleFaction) and is_array($roleFaction) and $roleFaction['fid'] != 0 and $roleFaction['role'] == 2){
                    $cache = CCache::getContent(md5('faction'.$roleFaction['fid'].'info').'.cch', 30);
                    if(!$cache){
                        $result = $curl->run($this->apiUrl.'faction/info', array(
                            'factionId' => $roleFaction['fid']
                        ))->getData(true);

                        if($result['status'] == 1){
                            $faction = $result['data'];
                            CCache::setContent($faction);
                        }
                    }else{
                        $faction = $cache;
                    }
                }

                if(isset($faction)){
                    $this->view->factionId = $faction['fid'];
                    $this->view->factionName = $faction['name'];
                    $this->view->factionLevel = $faction['level'];
                }else{
                    $msg = My::t('app', 'The selected character is not a master of the guild.');
                    $msg .= '<br />'.My::t('app', 'You can repeat this operation {time}', array('{time}'=>CTime::makePretty(CCache::getFileLifetime()+1800)));
                    $messageType = 'error';
                    $this->view->offline = 1;
                }

                if($request->getPost('act') == 'send' and isset($faction)){
                    if(APP_MODE == 'demo'){
                        $msg = My::t('core', 'Blocked in Demo Mode.');
                        $messageType = 'warning';
                    }else{
                        $icon = Icon::model()->findByAttributes(array('role_id'=>$roleId, 'faction_id'=>$faction['fid']));
                        /** @var User $user */
                        $user = User::model()->findByPk(CAuth::getLoggedId());
                        if($icon !== null){
                            $msg = My::t('app', 'You have already applied request, wait until the administrator approves your request.');
                            $messageType = 'error';
                        }elseif($service->price > $user->coins){
                            $msg = My::t('app', 'Not enough coins');
                            $messageType = 'error';
                        }elseif($faction['level'] !== 2){
                            $msg = My::t('app', 'Faction should be 3 level.');
                            $messageType = 'error';
                        }else{
                            $result = CWidget::create('CFormValidation', array(
                                'fields'=>array(
                                    'icon'=>array('title'=>'Icon', 'validation'=>array('required'=>true, 'type'=>'image', 'maxSize'=>'128k', 'minWidth'=>16, 'minHeight'=>16, 'maxWidth'=>16, 'maxHeight'=>16, 'mimeType'=>'image/png', 'targetPath'=>'guildicons/', 'fileName'=>$faction['fid']))
                                )
                            ));
                            if($result['error']){
                                $msg = $result['errorMessage'];
                                $messageType = 'validation';
                            }else{
                                $icon = new Icon;
                                $icon->account_id = CAuth::getLoggedId();
                                $icon->role_id = $roleId;
                                $icon->role_name = $roleName;
                                $icon->faction_id = $faction['fid'];
                                $icon->faction_name = $faction['name'];
                                $icon->request_date = time();
                                if($icon->save()){
                                    $log = new ServiceLog;
                                    $log->account_id = CAuth::getLoggedId();
                                    $log->service_id = My::t('app', 'Submitting a faction logo').' ('.$icon->faction_name.')';
                                    $log->ip_address = CIp::getBinaryIp();
                                    $log->request_date = time();
                                    $log->request_data = json_encode(array('roleid'=>$roleId, 'price'=>$service->price));
                                    $log->save();

                                    $user->coins = $user->coins - $service->price;
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
        $this->view->setMetaTags('title', My::t('app', 'Submitting a faction logo'));
        $this->view->render('icon/index', $request->isAjaxRequest());
    }

    /**
     * Icon admin action handler
     */
    public function adminAction()
    {
        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('index/index');
        }

        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        if($request->getPost('act') == 'remove'){
            $id = $request->getPost('id');
            /** @var Icon $icon */
            $icon = Icon::model()->findByPk($id);
            if($icon !== null){
                $result = CFile::deleteFile('guildicons/'.$icon->faction_id.'.png');
                if($result and $icon->delete()){
                    echo My::t('app', 'Successfully');
                }else{
                    echo My::t('app', 'Failed');
                }
            }
            exit;
        }

        if($request->getQuery('step') == 'parse'){
            if($this->parseIcons()){
                $msg = My::t('app', 'Successfully');
                $messageType = 'success';
            }else{
                $msg = My::t('app', 'Failed');
                $messageType = 'error';
            }
        }

        if($request->getQuery('step') == 'save'){
            if($this->saveIcons()){
                $msg = My::t('app', 'Successfully');
                $messageType = 'success';
            }else{
                $msg = My::t('app', 'Failed');
                $messageType = 'error';
            }
        }

        $this->view->targetPath = 'icon/admin';
        $this->view->pageSize = 20;
        $this->view->currentPage = $request->getQuery('page', 'integer', 1);
        $this->view->totalRecords = Icon::model()->count();
        $this->view->icons = Icon::model()->findAll(array('limit'=>(($this->view->currentPage - 1) * $this->view->pageSize).', '.$this->view->pageSize, 'order'=>'request_date DESC'));

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Submitting a faction logo'));
        $this->view->render('icon/admin', $request->isAjaxRequest());
    }

    protected function parseIcons()
    {
        if(APP_MODE == 'demo'){
            exit(My::t('core', 'This operation is blocked in Demo Mode. <a href="{base_url}">Back to site</a>', array('{base_url}'=>My::app()->getRequest()->getBaseUrl())));
        }

        $pngFile = APP_PATH.'/guildicons/iconlist_guild.png';
        $txtFile = APP_PATH.'/guildicons/iconlist_guild.txt';
        if(!file_exists($pngFile) or !file_exists($txtFile)){
            return false;
        }else{
            $file = file($txtFile);
            $sizeY = trim($file[0]);
            $sizeX = trim($file[1]);
            $countX = trim($file[3]);
            array_splice($file, 0, 4);
            $icons = array_values($file);
            $lineX = 0;
            $lineY = 0;
            $posX = 0;
            $image = imagecreatefrompng($pngFile);

            foreach($icons as $icon){
                if($posX < ($countX - 1) * $sizeX){
                    $posX = $sizeX * $lineX;
                    $posY = $sizeY * $lineY;
                    $lineX++;
                }else{
                    $lineX = 0;
                    $lineY++;
                    $posX = $sizeX * $lineX;
                    $posY = $sizeY * $lineY;
                    $lineX++;
                }

                $newIcon = imagecreate($sizeX, $sizeY);
                imagecopy($newIcon, $image, 0, 0, $posX, $posY, $sizeX, $sizeY);
                $icon = explode('_', $icon);
                $icon = explode('.dds', $icon[1]);
                $icon = APP_PATH.'/guildicons/'.$icon[0].'.png';
                if(!file_exists($icon)){
                    imagepng($newIcon, $icon);
                }
            }
            return true;
        }
    }

    protected function saveIcons()
    {
        if(APP_MODE == 'demo'){
            exit(My::t('core', 'This operation is blocked in Demo Mode. <a href="{base_url}">Back to site</a>', array('{base_url}'=>My::app()->getRequest()->getBaseUrl())));
        }

        $nl = "\n";
        $size = CConfig::get('guildicons.size_x');
        $server = CConfig::get('guildicons.server_id');

        $pngFile = APP_PATH.'/guildicons/iconlist_guild.png';
        $txtFile = APP_PATH.'/guildicons/iconlist_guild.txt';

        $files = scandir(APP_PATH.'/guildicons/');
        $icons = array();
        foreach($files as $icon){
            if(pathinfo($icon, PATHINFO_EXTENSION) == 'png' and $icon !== '0.png' and $icon !== 'iconlist_guild.png'){
                $icons[] = $icon;
            }
        }

        $file = fopen($txtFile, 'w+');
        ftruncate($file, 0);
        fwrite($file, '16'.$nl.'16'.$nl);
        $columns = $size / 16;
        $rows = ceil((count($icons) + 1) * 4 / $columns);
        fwrite($file, $rows.$nl.$columns.$nl);

        $iconList = imagecreatetruecolor(16 * $columns, 16 * $rows);
        $bg = imagecolorallocatealpha($iconList, 0, 0, 0, 127);
        imagefill($iconList, 0, 0, $bg);
        imagesavealpha($iconList, true);

        fwrite($file, '0_0.dds'.$nl);

        $icon = imagecreatefrompng(APP_PATH.'/guildicons/0.png');
        imagesavealpha($icon, true);
        imagecopy($iconList, $icon, 0, 0, 0, 0, 16, 16);
        $counter = 1;
        $posY = 0;

        foreach($icons as $icon){
            if($counter < $columns){
                $posX = 16 * $counter;
            }else{
                $counter = 0;
                $posX = 16 * $counter;
                $posY = $posY + 16;
            }

            $faction = explode('.', $icon);
            fwrite($file, $server.'_'.$faction[0].'.dds'.$nl);
            $icon = imagecreatefrompng(APP_PATH.'/guildicons/'.$faction[0].'.png');
            imagesavealpha($icon, true);
            imagecopy($iconList, $icon, $posX, $posY, 0, 0, 16, 16);
            $counter++;
        }
        imagepng($iconList, $pngFile);
        fclose($file);

        $version = file_get_contents(APP_PATH.'/guildicons/version.ini');
        $file = fopen(APP_PATH.'/guildicons/version.ini', 'w+');
        ftruncate($file, 0);
        fwrite($file, (int)$version + 1);
        fclose($file);

        Icon::model()->deleteAll();
        return true;
    }
}