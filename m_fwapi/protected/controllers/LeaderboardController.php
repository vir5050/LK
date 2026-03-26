<?php
/**
 * LeaderboardController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class LeaderboardController extends CController
{
    /**
     * Class default constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function updateRolesAction()
    {
        $db = CDatabase::init();
        $users = $db->select('SELECT uid FROM point WHERE lastlogin > :lastlogin', [':lastlogin'=>date('Y-m-d', time()-604800).' 00:00:00']);
        if(!empty($users)){
            Role::model()->deleteAll();

            /** @var CProtocol $protocol */
            $protocol = My::app()->getProtocol();
            $version = CConfig::get('server.version');
            $structure = $protocol->loadStructure($version);
            for($i = 0, $usersCount = count($users); $i < $usersCount; $i++){
                $userRoles = new User();
                $userRoles = $userRoles->roles($users[$i]['uid']);
                if(!empty($userRoles)){
                    for($j = 0, $rolesCount = count($userRoles); $j < $rolesCount; $j++){
                        $role = Role::GetRole($userRoles[$j]['id']);
                        if(!empty($role['base']['id']) and !empty($role['base']['name'])){
                            $f = [];
                            $f['id'] = $role['base']['id'];
                            $f['name'] = $role['base']['name'];
							$f['race'] = $role['status']['race'];
                            $f['occupation'] = $role['status']['occupation'];
                            $f['spouse'] = $role['base']['spouse'];
                            $f['gender'] = $role['base']['gender'];
                            $f['level'] = $role['status']['level'];
                            $f['pkvalue'] = $role['status']['pkvalue'];
                            $f['reputation'] = $role['status']['reputation'];
                            $f['time_used'] = $role['status']['time_used'];

							$f['crs_server_viplevel'] = $role['status']['crs_server_viplevel'];
							$f['combatkills'] = $role['status']['combatkills'];
							$f['bind_money'] = $role['pocket']['bind_money'];
							$f['money'] = $role['pocket']['money'];
                            $db->insert('mw_roles', $f);
                            unset($f);
                        }else{
                            echo $userRoles[$j]['id'].' empty role<br>';
                        }
                        unset($role);
                    }
                }else{
                    echo $users[$i]['uid'].' empty roles<br>';
                }
                unset($roles);
                set_time_limit(60);
            }
        }else{
            echo 'empty users<br>';
        }

        var_dump(CDatabase::getErrorMessage());
        		
		echo '<br />Successfully!';
    }

    /**
     * Leaderboard roles action handler
     */
    public function rolesAction()
    {
        /** @var Role $model */
        $model = Role::model();
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $criteria = $request->getPost('criteria');
        $limit = $request->getPost('limit');
        $bad = $request->getPost('bad');
        if(!empty($criteria)){
            $where = '';
            $order = '';
            $criteria = explode(',', $criteria);
            foreach($criteria as $key){
                $order .= $key.' DESC,';
            }
            $order = substr($order, 0, -1);

            if(!empty($bad)){
                $where .= 'id NOT IN ('.$bad.')';
            }

            $roles = $model->findAll(['condition'=>$where, 'order'=>$order, 'limit'=>$limit]);
        }else{
            $roles = [];
        }

        $this->view->renderJson(['total'=>$model->count(), 'roles'=>$roles]);
    }

    /**
     * Leaderboard factions action handler
     */
    public function factionsAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $limit = $request->getPost('limit', 'integer', 5);
        $factions = CDatabase::init()->customQuery('SELECT mw_factions.*, mw_roles.name as master_name FROM mw_factions INNER JOIN mw_roles ON mw_roles.id = mw_factions.master ORDER BY members DESC LIMIT 0,'.$limit);
        echo CDatabase::getErrorMessage();
        $this->view->renderJson($factions);
    }
}