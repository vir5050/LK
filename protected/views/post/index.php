<div class="subhead"><?php echo $this->_pageTitle; ?></div>
<?php echo $actionMessage; ?>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'post/',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'post-form',
            'class'=>'light-form',
            'style'=>'float: none;',
            'onkeypress'=>'if (event.keyCode == 13) return false;'
        ),
        'fields'=>array(
            'act' =>array('type'=>'hidden', 'value'=>(!empty($id) ? 'edit' : 'add')),
            'id' =>array('type'=>'hidden', 'value'=>$id),
            'title'=>array('type'=>'textbox', 'value'=>$title, 'title'=>My::t('app', 'Title'), 'htmlOptions'=>array('class'=>'field large', 'autocomplete'=>'off', 'autofocus'=>true)),
            'message'=>array('type'=>'textarea', 'value'=>$message, 'htmlOptions'=>array('class'=>'field', 'style'=>'height: 250px;')),
            'author'=>array('type'=>'textbox', 'value'=>CAuth::getLoggedParam('loggedDisplayName'), 'title'=>My::t('app', 'Author').':', 'htmlOptions'=>array('class'=>'field')),
            'tags'=>array('type'=>'textbox', 'value'=>$tags, 'title'=>My::t('app', 'Tags').':', 'htmlOptions'=>array('class'=>'field', 'placeholder'=>'News, Updates etc.')),
			'img'=>array('type'=>'textbox', 'value'=>$img, 'title'=>My::t('app', 'img').':', 'htmlOptions'=>array('class'=>'field', 'placeholder'=>'News, Updates etc.')),
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Submit'), 'htmlOptions'=>array('class'=>'button blue')),
        ),
        'return'=>true,
    )); ?>
</div>