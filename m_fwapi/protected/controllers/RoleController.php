<?php

/**
 * RoleController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * getAction
 *
 */
class RoleController extends CController
{
    /**	@var int */
    public $error = 1;
    /**	@var int */
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
     * Role rid2uid action handler
     */
    public function rid2uidAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $roleId = $request->getPost('roleid');
        if(!empty($roleId)){
            $userId = Role::Roleid2Uid($roleId);
            if($userId===null){
                $this->error = 2;
            }else{
                $this->error = 0;
                $this->status = 1;
                $this->data = ['userid'=>$userId];
            }
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    /**
     * Role get action handler
     */
    public function getAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $roleId = $request->getPost('roleid');
        $part = $request->getPost('part');
        if(!empty($roleId)){
            if(!preg_match('/^[0-9]+$/', $roleId)) $roleId = Role::GetRoleId($roleId);
            if(!is_array($part)) $part = explode(',', $part);
            $role = Role::GetRole($roleId, $part);
        }

        if(!isset($role) and empty($role)){
            $this->error = 2;
        }else{
            $this->error = 0;
            $this->status = 1;
            $this->data = [
                'role'=>$role
            ];
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    /**
     * Role put action handler
     */
    public function putAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $roleId = $request->getPost('roleid');
        $roleData = $request->getPost('value');
        $part = $request->getPost('part');
        if(!empty($roleId) and !empty($roleData)){
            if(!preg_match('/^[0-9]+$/', $roleId)) $roleId = Role::GetRoleId($roleId);
            $roleData = json_decode($roleData, true);
            if(Role::PutRole($roleId, $roleData, $part)){
                $result = true;
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
     * Role clearstorehousepasswd action handler
     */
    public function clearstorehousepasswdAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $roleId = $request->getPost('roleid', 'integer');
        $roleName = $request->getPost('rolename');
        if(!empty($roleId) and !empty($roleName)){
            if(CConfig::get('server.version') == 'pw.07'){
                $role = Role::GetRole($roleId, ['status']);
                $role['status']['storehousepasswd'] = '';
                Role::PutRole($roleId, $role, 'status');
                $result = true;
            }else{
                $result = Role::ClearStorehousePasswd($roleId, $roleName);
            }
        }

        if(isset($result) and $result===true){
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
     * Role getid action handler
     */
    public function getidAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $roleName = $request->getPost('rolename');
        if(!empty($roleName)){
            $roleId = Role::GetRoleId($roleName);
        }

        if(isset($roleId)){
            $this->error = 0;
            $this->status = 1;
            $this->data['roleid'] = $roleId;
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
     * Role rename action handler
     */
    public function renameAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $roleId = $request->getPost('roleid', 'integer');
        $oldName = $request->getPost('oldname');
        $newName = $request->getPost('newname');
        if(!empty($roleId) and !empty($oldName) and !empty($newName)){
            $result = Role::RenameRole($roleId, $oldName, $newName);
            if(CConfig::get('server.version') == 'pw.07'){
                Role::GMForbidRole(100, $roleId, 3600, 'Rename role', 1024);
            }
        }

        if(isset($result) and $result===true){
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
     * Role forbid action handler
     */
    public function forbidAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $gm = $request->getPost('gm', 'integer', 1024);
        $fbd_type = $request->getPost('type', 'integer');
        $roleId = $request->getPost('roleid', 'integer');
        $time = $request->getPost('time', 'integer');
        $reason = $request->getPost('reason');
        if(!empty($fbd_type) and !empty($roleId) and !empty($time) and !empty($reason)){
            $result = Role::GMForbidRole($fbd_type, $roleId, $time, $reason, $gm);
        }

        if(isset($result) and $result===true){
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
     * Role faction action handler
     */
    public function factionAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $roleId = $request->getPost('roleid');
        if(!empty($roleId)){
            $faction = Role::UserFaction($roleId);
            if($faction!==null){
                $this->error = 0;
                $this->status = 1;
                $this->data = $faction;
            }else{
                $this->error = 2;
            }
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    public function deleteAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $roleId = $request->getPost('roleid');
        if(!empty($roleId)){
            $result = Role::DBDeleteRole($roleId);
            if($result!==null){
                $this->error = 0;
                $this->status = 1;
                $this->data = $result;
            }else{
                $this->error = 2;
            }
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    public function teleportAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $roleId = $request->getPost('roleid');
        $worldtag = $request->getPost('worldtag');
        $pos_x = $request->getPost('pos_x');
        $pos_y = $request->getPost('pos_y');
        $pos_z = $request->getPost('pos_z');
        if(!empty($roleId)){
            if(CConfig::get('server.version') == 'pw.07'){
                $role = Role::GetRole($roleId, ['status']);
                $role['status']['posx'] = $pos_x;
                $role['status']['posy'] = $pos_y;
                $role['status']['posz'] = $pos_z;
                $role['status']['worldtag'] = $worldtag;
                Role::PutRole($roleId, $role, 'status');
                $result = true;
            }else{
                $result = Role::DBPlayerPositionReset($roleId, $worldtag, $pos_x, $pos_y, $pos_z);
            }

            if($result===true){
                $this->error = 0;
                $this->status = 1;
            }else{
                $this->error = 2;
            }
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status
        ]);
    }
}