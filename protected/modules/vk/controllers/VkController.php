<?php
/**
* VkController
*
* PUBLIC:                  	PRIVATE
* -----------              	------------------
* __construct
*
*/

class VkController extends CController
{
    public function __construct()
    {
        parent::__construct();

        $this->view->actionMessage = '';
    }

    /**
     * Controller default action handler
     */
    public function indexAction()
    {
        //$this->redirect('admin/dashboard');
    }

    /**
     * VK repost action handler
     */
    public function repostAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $code = $request->getQuery('code');
        /** @var Vk $vk */
        $vk = Vk::model()->findByAttributes(array('account_id'=>CAuth::getLoggedId()));
        /** @var Settings $settings */
        $settings = VkSettings::model()->findByPk(1);
        /** @var VKApi $vk */
        $VKApi = VKApi::init();
        $VKApi->setOptions(array(
            'client_id'=>4706315,
            'secret_key'=>'YISxwnSm2RBPUdigk0rN',
            'user_id'=>0,
            'access_token'=>'',
            'scope'=>'friends,wall'
        ));

        if($vk===null){
            if($code===''){
                $this->view->authorizeUrl = $VKApi->getAuthorizeUrl();
            }else{
                $response = $VKApi->getToken($code);
                if(isset($response['access_token']) and isset($response['user_id']) and !empty($response['access_token']) and !empty($response['user_id'])){
                    $countUserId = Vk::model()->countByAttributes(array('account_id'=>CAuth::getLoggedId()));
                    $countUserVk = Vk::model()->countByAttributes(array('vk_user_id'=>$response['user_id']));
                    if($countUserId===0 and $countUserVk===0){
                        $model = new Vk;
                        $model->account_id = CAuth::getLoggedId();
                        $model->vk_user_id = $response['user_id'];
                        $model->ip_address = CIp::getBinaryIp();
                        $model->request_date = time();
                        if($model->save()){
                            $this->redirect('vk/repost');
                        }else{
                            $message = My::t('app', 'Failed');
                            $messageType = 'warning';
                        }
                    }else{
                        $message = My::t('app', 'Failed');
                        $messageType = 'error';
                    }
                }else{
                    $message = My::t('app', 'Failed');
                    $messageType = 'warning';
                }
            }
        }else{
            $user = $VKApi->api('users.get', array(
                'user_ids'=>$vk->vk_user_id,
                'fields'=>'photo_50,deactivated',
                'name_case'=>'Nom'
            ));

            if(isset($user[0]['deactivated']) and ($user[0]['deactivated'] == 'deleted' or $user[0]['deactivated'] == 'banned')){
                $message = My::t('app', 'Ваш аккаунт удален или заблокирован. Дальнейшие действия невозможны.');
                $messageType = 'error';
                unset($user);
            }else{
                /*$friends = $VKApi->api('friends.get', array(
                    'user_id'=>$vk->vk_user_id
                ));

                if($friends['count'] < $settings->friends_required){
                    $message = My::t('app', 'Требуемое количество друзей - {required}, у Вас - {count}.<br />Возможно Вы скрыли их в Ваших настройках приватности.', array('{required}'=>$settings->friends_required, '{count}'=>$friends['count']));
                    $messageType = 'info';
                }*/

                /*$posts = $VKApi->api('wall.getById', array(
                    'posts'=>$settings->posts,
                    'extended'=>0
                ));*/
            }
        }

        if(isset($message) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $message));
        }

        $this->view->user = isset($user) ? (object)$user[0] : null;
        $this->view->setMetaTags('title', My::t('app', 'VK Repost'));
        $this->view->render('vk/repost', $request->isAjaxRequest());
    }
}