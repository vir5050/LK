<?php

/**
 * UserController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * getAction
 *
 */
class UserController extends CController
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
     * User get action handler
     */
    public function getAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $model = new User;

        $id = $request->getPost('ID');
        $name = $request->getPost('name');
        if(!empty($id)){
            $user = $model->getUserById($id);
        }elseif(!empty($name)){
            $user = $model->getUserByName($name);
        }

        if(!isset($user)){
            $this->error = 2;
        }else{
            $this->error = 0;
            $this->status = 1;
            $this->data = [
                'user'=>$user
            ];
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    /**
     * User update action handler
     */
    public function updateAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $model = new User;

        $id = $request->getPost('ID');
        $params = $request->getPost('params');
        if(!empty($id) and !empty($params)){
            $params = json_decode($params, true);
            $update = $model->updateUser($id, $params);
        }else{
            $update = false;
        }

        if(isset($update) and $update===true){
            $this->error = 0;
            $this->status = 1;
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
     * User register action handler
     */
    public function registerAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $model = new User;

        $name = $request->getPost('name');
        $password = $request->getPost('passwd');
        $email = $request->getPost('email');
        if(!empty($name) and !empty($password) and !empty($email)){
            if($model->addUser($name, $password, $email) !== false){
                $user = $model->getUserByName($name);
                $this->error = 0;
                $this->status = 1;
                $this->data = [
                    'user_id'=>$user['ID']
                ];
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

    /**
     * User cubigold action handler
     */
    public function cubigoldAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $model = new User;

        $id = $request->getPost('id');
        $count = $request->getPost('count');
        if(!empty($id) and !empty($count)){
            if($model->addCash($id, $count) !== false){
                $this->error = 0;
                $this->status = 1;
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

    /**
     * User roles action handler
     */
    public function rolesAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $userId = $request->getPost('userid');
        if(!empty($userId)){
            $roles = User::roles($userId);

            if($roles===null){
                $this->error = 2;
            }else{
                foreach ($roles as $i => $role) {
					$data = Role::GetRole($role['id']);
					$roles[$i]['occupation'] = $data['status']['occupation'];
				}
				$this->error = 0;
                $this->status = 1;
                $this->data = $roles;
            }
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    /**
     * User info action handler
     */
    public function infoAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $userId = $request->getPost('userid', 'integer');
        if(!empty($userId)){
            $user = User::info($userId);

            if($user===null){
                $this->error = 2;
            }else{
                $this->error = 0;
                $this->status = 1;
                $this->data = $user;
            }
        }

        $this->view->renderJson([
            'error'=>$this->error,
            'status'=>$this->status,
            'data'=>$this->data
        ]);
    }

    /**
     * User kickout action handler
     */
    public function kickoutAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $gmuserid = $request->getPost('gm', 'integer', 1024);
        $roleId = $request->getPost('roleid', 'integer');
        $time = $request->getPost('time', 'integer', 3600);
        $reason = $request->getPost('reason', '', 'Misfit');
        if(!empty($roleId) and !empty($time) and !empty($reason)){
            $userId = Role::Roleid2Uid($roleId);
            if(!empty($userId)){
                User::kickout($userId, 1, $reason, $gmuserid);
                if($time = 0){
                    $operation = 0;
                }else{
                    $operation = 1;
                }
                $result = User::forbid($operation, $gmuserid, 0, $userId, $time, $reason);
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
     * Role shutup action handler
     */
    public function shutupAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $gm = $request->getPost('gm', 'integer', 1024);
        $userId = $request->getPost('userId', 'integer');
        $time = $request->getPost('time', 'integer', 3600);
        $reason = $request->getPost('reason', '', 'Misfit');
        if(!empty($userId)){
            $result = User::shutup($userId, $time, $reason, $gm);
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
}