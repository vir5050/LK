<?php

class Sidebar extends CComponent
{
    /**
     * Class constructor
     * @return Sidebar
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public static function init()
    {
        return parent::init(__CLASS__);
    }

    public function serverStatus($viewBlock = false)
    {
        $output = '';
        if($viewBlock){
            $cache = CCache::getContent(md5('server.status').'.cch', 5);
            if(!$cache){
                $fp = @fsockopen(CConfig::get('serverIp'), CConfig::get('serverPort'), $errno, $errstr, 5);
                if(!$fp){
                    $status = 'offline';
                }else{
                    $status = 'online';
                    fclose($fp);
                }

                $result = My::app()->getCurl()->run(CConfig::get('apiUrl').'server/online')->getData(true);

                if($result['status'] == 1){
					$online = $result['data'];
					
					// прибавляем фейковый онлайн
					$online += rand(3, 7);
                }else{
                    $online = 0;
                }

                $load = round($online * (100 / CConfig::get('max_online')), 2);

                CCache::setContent(array('status'=>$status, 'online'=>$online, 'load'=>$load));
            }else{
                $status = isset($cache['status']) ? $cache['status'] : 'offline';
                $online = isset($cache['online']) ? $cache['online'] : 0;
                $load = isset($cache['load']) ? $cache['load'] : 0;
            }

            $output .= '
			
			
			
            <b class="timeserver" style="width: 100%;text-align: center;font-family: Beaufort;font-size: 24px;color: #c11515;left: -10px;right: 0;margin: auto;">Статус:
			<span class="'.$status.'" style="width: 100%;text-align: center;font-family: Beaufort;font-size: 24px;">'.$status.'</span>
			<p id="seconds" style="width: 100%;text-align: center;font-family: Beaufort Bold;font-size: 46px;color: #562200;">
			0</p></b>
			
			
			';
        }

        return $output;
    }

    public function playerLeaderboards($viewBlock = true)
    {
        $output = '';
        if($viewBlock){
            $criteria = CConfig::get('leaderboards.roles.criteria');
            $limit = CConfig::get('leaderboards.roles.limit');
            $bad = CConfig::get('leaderboards.roles.bad');
            $limit = '0,'.$limit;

            $cache = CCache::getContent(md5('leaderboards'.$criteria.$limit).'.cch', 1440);
            if(!$cache){
                $result = My::app()->getCurl()->run(CConfig::get('apiUrl').'leaderboard/roles', array(
                    'criteria'=>$criteria,
                    'limit'=>$limit,
                    'bad'=>$bad
                ))->getData(true);

                if(isset($result['total']) and $result['total'] > 0){
                    CCache::setContent($result);
                    $roles = $result['roles'];
                }
            }else{
                $roles = $cache['roles'];
            }


                if(!empty($roles)){
                    $output .= '<table style="position: relative;width: 90%;height: 65px;top: 30px;left: 0;right: 0;bottom: 0;margin: auto;">
                        <tr style="padding: 4px 10px;background-color: #ff9500;text-align: left;height: 20px;">
                            <th style="color: #fff;">'.My::t('app', 'Character').'</th> 
							<th style="color: #fff;">Проф</th>
                            <th style="color: #fff;">'.My::t('app', 'Level').'</th>
                            <th style="color: #fff;">'.My::t('app', 'Пол').'</th>
							<th style="color: #fff;">'.My::t('app', 'Time in game').'</th>
                        </tr>';
                    foreach($roles as $role){
                        $output .= '<tr style="font-size: 16px;font-family: Roboto Bold;color:#ff7f00;">
                            <td style="height: 30px; border-bottom: 1px solid rgb(218, 226, 232);">'.$role['name'].'</td>
							<td style="height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><span class="role-cls" style="background: url(\'/images/occupation/'.$role['occupation'].'.png\'); background-size: cover; width: 25px; height: 25px;"></span></td>
							<td style="height: 30px; border-bottom: 1px solid rgb(218, 226, 232);">'.$role['level'].'</td>
                            <td style="height: 30px; border-bottom: 1px solid rgb(218, 226, 232);"><span class="role-cls" style="background: url(\'/images/occupation/gender/'.$role['gender'].'.png\'); background-size: cover; width: 25px; height: 25px;"></span></td>
                            <td style="height: 30px; border-bottom: 1px solid rgb(218, 226, 232);">'.self::online($role['time_used']).'</td>
                        </tr>';
                    }
                    $output .= '</table>';
                }

        }

        return $output;
    }

    public function bestFactions($viewBlock = false)
    {
        $output = '';
        if($viewBlock){
            $cache = CCache::getContent(md5('best.factions').'.cch', 1440);
            if(!$cache){
                $factions = My::app()->getCurl()->run(CConfig::get('apiUrl').'leaderboard/factions', array(
                    'limit'=>CConfig::get('leaderboards.factions.limit')
                ))->getData(true);

                if(!empty($factions)){
                    CCache::setContent($factions);
                }
            }else{
                $factions = $cache;
            }

            $output .= '<fieldset class="secondary-content">
                <legend class="content-head">'.My::t('app', 'Лучшие Альянсы').'</legend>
                <div class="list-rows">';
            if(!empty($factions)){
                $output .= '<table class="leaderboards-table">
                        <tr>
                            <th style="text-align: left; padding-left: 5px;">'.My::t('app', 'Альянс').'</th>
                            <th>'.My::t('app', 'Глава').'</th>
                            <th>'.My::t('app', 'Гильдий').'</th>
                        </tr>';
                foreach($factions as $faction){
                    $icon = (file_exists(APP_PATH.'/guildicons/'.$faction['id'].'.png') ? 'guildicons/'.$faction['id'].'.png' : 'guildicons/0.png');
                    $output .= '<tr>
                            <td style="text-align: left;">
                                <span><img src="'.$icon.'" width="14" height="14" /></span>
                                <span>'.$faction['name'].'</span>
                            </td>
                            <td>'.$faction['master_name'].'</td>
                            <td>'.$faction['members'].'</td>
                        </tr>';
                }
                //$output .= '<tr><td colspan="5" style="text-align: center; border: none; padding-bottom: 0; padding-top: 8px;"><a style="font-size: 12px; color: rgb(255, 255, 255);" href="battlemap/">'.My::t('app', 'Open battle map').'</a></td></tr>
                $output .= '</table>';
            }else{
                $output .= '<p align="center">No result</p>';
            }
            $output .= '</div>
            </fieldset>';
        }

        return $output;
    }

    public function serverStaff($viewBlock = false)
    {
        $output = '';
        if($viewBlock){
            $cache = CCache::getContent(md5('server.staff').'.cch', 15);
            if(!$cache){
                $result = My::app()->getCurl()->run(CConfig::get('apiUrl').'server/online', array(
                    'what'=>'list',
                    'list'=>json_encode(array_keys(CConfig::get('staff')))
                ))->getData(true);

                if($result['status'] == 1){
                    $online = $result['data'];
                }else{
                    $online = array();
                }

                CCache::setContent(array('online'=>$online));
            }else{
                $online = $cache['online'];
            }

            $output .= '<fieldset class="secondary-content">
                <legend class="content-head">'.My::t('app', 'Server staff').'</legend>
                <div class="list-pairs">';
                foreach(CConfig::get('staff') as $id => $staff){
                    $output .= ' <dl>
                        <dt><span style="color: rgb(0, 172, 255);">'.$staff['role'].'</span> '.$staff['character'].'</dt>
                        <dd class="'.((isset($online[$id]) and $online[$id] != '') ? 'online' : 'offline').'">'.((isset($online[$id]) and $online[$id] != '') ? My::t('app', 'In-game') : 'Offline').'</dd>
                    </dl>';
                }
                $output .= '</div>
            </fieldset>';
        }

        return $output;
		
    }

    public static function online($seconds)
    {
        $days = floor($seconds / 86400);
        $hours = floor(floor($seconds - ($days * 86400)) / 3600);
        $online = '<span style="margin: 0 3px 0 0; color: rgb(124, 252, 0); width: 50%; text-align: right;">'.$days.' '.My::t('i18n', 'time.abbreviated.days').'.</span> ';
        $online .= $hours.' '.My::t('i18n', 'time.narrow.hours').'.';

        return $online;
    }
}