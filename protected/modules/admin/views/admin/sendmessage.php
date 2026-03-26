<div class="subhead"><?php echo My::t('app', 'Broadcast message'); ?></div>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'admin/send-message',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'send'),
            'message'=>array('type'=>'textbox', 'title'=>My::t('app', 'Message').':', 'htmlOptions'=>array('class'=>'field large')),
            'channel'=>array('type'=>'radiobuttonlist', 'data'=>My::t('app', 'channels'), 'checked'=>9, 'htmlOptions'=>array('class'=>'field', 'onchange'=>'if (this.value == 4) { ge(\'receiver\').classList.add(\'active\'); } else { ge(\'receiver\').classList.remove(\'active\'); }')),
            'receiver'=>array('type'=>'textbox', 'title'=>My::t('app', 'Receiver'), 'htmlOptions'=>array('class'=>'field disabled', 'id'=>'receiver'))
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Confirm operation'), 'htmlOptions'=>array('class'=>'button blue-gradient left-float'))
        ),
        'events'=>array(
            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
        ),
        'return'=>true
    )); ?>
</div>
<?php echo $actionMessage; ?>