<?php
/**
 * PostController
 *
 * PUBLIC:				  PRIVATE
 * -----------			  ------------------
 * __construct
 * indexAction
 *
 */

class PostController extends CController
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
        if(!CAuth::isLoggedInAsAdmin()){
            $this->redirect('index/index');
        }

        /** @var CHttpRequest $request */
        $request = My::app()->getRequest();

        $this->view->title = '';
        $this->view->message = '';
        $this->view->tags = '';
		$this->view->img = '';
        $this->view->id = $request->getQuery('edit', 'integer');

        if($this->view->id !== ''){
            $post = Post::model()->findByPk($this->view->id);

            $this->view->title = $post->title;
            $this->view->message = CHtml::decode($post->message);
            $this->view->tags = $post->tags;
			$this->view->img = $post->img;
        }

        if(APP_MODE == 'demo'){
            $msg = My::t('core', 'Blocked in Demo Mode.');
            $messageType = 'warning';
        }else{
            if($request->getPost('act') == 'add'){
                $this->view->title = $request->getPost('title');
                $this->view->message = $request->getPost('message');
                $this->view->author = $request->getPost('author');
                $this->view->tags = $request->getPost('tags');
				$this->view->img = $request->getPost('img');

                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        'title'=>array('title'=>My::t('app', 'Title'), 'validation'=>array('required'=>true, 'type'=>'any', 'minLength'=>1, 'maxLength'=>150)),
                        'message'=>array('title'=>My::t('app', 'Message'), 'validation'=>array('required'=>true, 'type'=>'any', 'minLength'=>1, 'maxLength'=>10000)),
                        'author'=>array('title'=>My::t('app', 'Author'), 'validation'=>array('required'=>false, 'type'=>'any')),
                        'tags'=>array('title'=>My::t('app', 'Tags'), 'validation'=>array('required'=>false, 'type'=>'any')),
						'img'=>array('title'=>My::t('app', 'img'), 'validation'=>array('required'=>false, 'type'=>'any')),
                    )
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    $post = new Post;
                    $post->user_id = CAuth::getLoggedId();
                    $post->post_date = time();
                    $post->title = $this->view->title;
                    $post->message = CHtml::encode($this->view->message);
                    $post->author = $this->view->author;
                    $post->tags = $this->view->tags;
$post->img = $this->view->img;
                    $post->ip_address = CIp::getBinaryIp();
                    if($post->save()){
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
                $this->view->author = $request->getPost('author');
                $this->view->tags = $request->getPost('tags');
				$this->view->img = $request->getPost('img');

                $result = CWidget::create('CFormValidation', array(
                    'fields'=>array(
                        'id'=>array('title'=>My::t('app', 'Title'), 'validation'=>array('required'=>true, 'type'=>'integer')),
                        'title'=>array('title'=>My::t('app', 'Title'), 'validation'=>array('required'=>true, 'type'=>'any', 'minLength'=>1, 'maxLength'=>150)),
                        'message'=>array('title'=>My::t('app', 'Message'), 'validation'=>array('required'=>true, 'type'=>'any', 'minLength'=>1, 'maxLength'=>10000)),
                        'author'=>array('title'=>My::t('app', 'Author'), 'validation'=>array('required'=>false, 'type'=>'any')),
                        'tags'=>array('title'=>My::t('app', 'Tags'), 'validation'=>array('required'=>false, 'type'=>'any')),
						'img'=>array('title'=>My::t('app', 'img'), 'validation'=>array('required'=>false, 'type'=>'any')),
                    )
                ));
                if($result['error']){
                    $msg = $result['errorMessage'];
                    $this->view->errorField = $result['errorField'];
                    $messageType = 'validation';
                }else{
                    $post = Post::model()->findByPk($this->view->id);
                    if($post !== null){
                        $post->title = $this->view->title;
                        $post->message = CHtml::encode($this->view->message);
                        $post->author = $this->view->author;
                        $post->tags = $this->view->tags;
						$post->img = $this->view->img;
                        if($post->save()){
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
        $script->registerScriptFile('http://demos.codexworld.com/add-wysiwyg-html-editor-to-textarea-website/tinymce/tinymce.min.js');
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
			    images_upload_url: 'upload.php',
    
    // override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
      
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', 'upload.php');
      
        xhr.onload = function() {
            var json;
        
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
        
            json = JSON.parse(xhr.responseText);
        
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
        
            success(json.location);
        };
      
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
      
        xhr.send(formData);
    },
        });", 1);

        if(isset($msg) and isset($messageType)){
            $this->view->actionMessage = CWidget::create('CMessage', array($messageType, $msg));
        }

        $this->view->setMetaTags('title', My::t('app', 'Add post'));
        $this->view->render('post/index');
    }

    /**
     * Post remove action handler
     */
    public function removeAction()
    {
        if(CAuth::isLoggedInAsAdmin()===false){
            $this->redirect('index/index');
        }

        $request = My::app()->getRequest();
        if($request->isPostExists('id')){
            $id = $request->getPost('id');
            if(CValidator::isInteger($id)){
                if(Post::model()->deleteByPk($id)){
                    exit('1');
                }
            }
        }
    }
}