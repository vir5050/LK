<?php
/**
 * MenuController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */
class MenuController extends CController
{
    /**
     * Class default constructor
     */
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
        $this->redirect('Index/index');
    }

    /**
     * Menu node action handler
     */
    public function nodeAction()
    {
        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();
        $id = $request->getQuery('id', 'integer');
        if(!empty($id)){
            $menu = Menu::model()->findByPk($id);
        }

        if(!isset($menu) or $menu===null){
            $this->redirect('Index/index');
        }

        $this->view->menu = $menu;
        $this->view->render('menu/node', $request->isAjaxRequest());
    }

    /**
     * Menu admin action handler
     */
    public function adminAction()
    {
        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('Index/index');
        }

        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $this->view->id = $request->getQuery('id', 'integer', '');
        $this->view->title = '';
        $this->view->message = '';
        $this->view->external_url = '';
        $this->view->position = '';
        $this->view->icon = '';

        if($this->view->id !== ''){
            $menu = Menu::model()->findByPk($this->view->id);
            if($menu!==null){
                $this->view->title = $menu->title;
                $this->view->message = CHtml::decode($menu->message);
                $this->view->external_url = $menu->external_url;
                $this->view->position = $menu->position;
                $this->view->icon = $menu->icon;
            }
        }

        if(APP_MODE == 'demo'){
            $msg = My::t('core', 'Blocked in Demo Mode.');
            $messageType = 'warning';
        }else{
            if($request->getPost('act') == 'add'){
                $this->view->title = $request->getPost('title');
                $this->view->message = $request->getPost('message');
                $this->view->external_url = $request->getPost('external_url');
                $this->view->position = $request->getPost('position');
                $this->view->icon = $request->getPost('icon');

                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        'title'=>array('title'=>My::t('app', 'Title'), 'validation'=>array('required'=>true, 'type'=>'any', 'minLength'=>1, 'maxLength'=>150)),
                        'message'=>array('title'=>My::t('app', 'Message'), 'validation'=>array('required'=>false, 'type'=>'any', 'minLength'=>1, 'maxLength'=>10000)),
                        'external_url'=>array('title'=>My::t('app', 'External url'), 'validation'=>array('required'=>false, 'type'=>'url'))
                    )
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    $menu = new Menu;
                    $menu->title = $this->view->title;
                    $menu->message = CHtml::encode($this->view->message);
                    $menu->external_url = $this->view->external_url;
                    $menu->position = $this->view->position;
                    $menu->icon = $this->view->icon;
                    if($menu->save()){
                        $msg = My::t('app', 'Successfully');
                        $messageType = 'success';
                    }else{
                        $msg = My::t('app', 'Failed');
                        $messageType = 'warning';
                    }
                }
            }

            if($request->getPost('act') == 'edit'){
                $this->view->id = $request->getPost('id');
                $this->view->title = $request->getPost('title');
                $this->view->message = $request->getPost('message');
                $this->view->external_url = $request->getPost('external_url');
                $this->view->position = $request->getPost('position');
                $this->view->icon = $request->getPost('icon');

                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        'id'=>array('title'=>My::t('app', 'Title'), 'validation'=>array('required'=>true, 'type'=>'integer')),
                        'title'=>array('title'=>My::t('app', 'Title'), 'validation'=>array('required'=>true, 'type'=>'any', 'minLength'=>1, 'maxLength'=>150)),
                        'message'=>array('title'=>My::t('app', 'Message'), 'validation'=>array('required'=>false, 'type'=>'any', 'minLength'=>1, 'maxLength'=>10000)),
                        'external_url'=>array('title'=>My::t('app', 'External url'), 'validation'=>array('required'=>false, 'type'=>'url'))
                    )
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    /** @var Menu $menu */
                    $menu = Menu::model()->findByPk($this->view->id);
                    if($menu !== null){
                        $menu->title = $this->view->title;
                        $menu->message = CHtml::encode($this->view->message);
                        $menu->external_url = $this->view->external_url;
                        $menu->position = $this->view->position;
                        $menu->icon = $this->view->icon;
                        if($menu->save()){
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

        $script = My::app()->getClientScript();
        $script->registerScriptFile('//tinymce.cachefly.net/4.1/tinymce.min.js');
        $script->registerScript('tinyMCE', "tinyMCE.init({
            selector:'textarea',
            skin_url:'".My::app()->getRequest()->getBaseUrl()."css/tinymce.default',
            language_url:'js/vendors/TinyMCE.ru_RU.js',
            plugins: [
                'advlist autolink lists link image preview hr anchor pagebreak',
                'wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons paste textcolor colorpicker textpattern'
            ],
            font_formats: 'Arial=arial,helvetica,sans-serif;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Helvetica Neue=Helvetica Neue,Helvetica,Arial,lucida grande,tahoma,verdana,arial,sans-serif;Impact=impact,chicago;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Verdana=verdana,geneva;Wingdings=wingdings,zapf dingbats',
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'preview media | fontsizeselect fontselect forecolor backcolor emoticons',
            image_advtab: true,
        });", 1);

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Manage menu'));
        $this->view->render('menu/admin', $request->isAjaxRequest());
    }

    /**
     * Menu remove action handler
     */
    public function removeAction()
    {
        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('Index/index');
        }

        $request = My::app()->getRequest();
        if($request->isPostExists('id')){
            $id = $request->getPost('id');
            if(CValidator::isInteger($id)){
                if(Menu::model()->deleteByPk($id)){
                    exit('1');
                }
            }
        }
    }

    /**
     * Menu icons action handler
     */
    public function iconsAction()
    {
        $this->view->render('menu/icons', true);
    }
}