<?php

class bar2 extends CComponent
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

            $output .= '<fieldset class="secondary-content">
                <legend class="content-head">'.My::t('app', 'Leaderboards').'</legend>
                <div class="list-rows">';
                if(!empty($roles)){
                    $output .= '<table class="table-top">
                        <tr>
                            <th style="text-align: left; padding-left: 5px;">'.My::t('app', 'Character').'</th> 
                            <th>'.My::t('app', 'Level').'</th>
                            <th>'.My::t('app', 'Time in game').'</th>
                            <th>'.My::t('app', 'Убийств').'</th>
                        </tr>';
                    foreach($roles as $role){
                        $output .= '<tr>
                            <td style="text-align: left;">
                                <span onmouseover="showTooltip(this, \''.My::t('app', 'occupation.'.$role['occupation']).'\', {target:this.parentNode, tipJoint:\'right\', offset:[-3, 0]});" class="role-cls" style="background: url(\'http://fw-arcadia.ru/images/occupation/'.$role['occupation'].'.png\') no-repeat; width: 20px; height: 20px;"></span>
                                <span>'.$role['name'].'</span>
                            </td>
                            <td>'.$role['level'].'</td>
                            <td style="white-space: nowrap;">'.self::online($role['time_used']).'</td>
                            <td>'.ceil($role['pkvalue'] / 7200).'</td>
                        </tr>';
                    }
                    $output .= '<tr><td colspan="4" style="border: none;"><a style="font-size: 12px; color: rgb(255, 255, 255);" href="leaderboards/roles" onclick="return go(this, event);">'.My::t('app', 'List of all leaderboards').'</a></td></tr>
                    </table>';
                }else{
                    $output .= '<p align="center">No result</p>';
                }
            $output .= '</div>
            </fieldset>';
        }

        return $output;
    }



}