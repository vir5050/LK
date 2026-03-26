<div class="subhead"><?php echo My::t('app', 'Forbid manager'); ?></div>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'admin/forbid',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'send'),
            'roleid'=>array('type'=>'textbox', 'title'=>My::t('app', 'Character').':', 'htmlOptions'=>array('class'=>'field')),
            'type'=>array('type'=>'radiobuttonlist', 'data'=>$forbidTypesList, 'checked'=>100, 'htmlOptions'=>array('class'=>'field')),
            'time'=>array('type'=>'textbox', 'title'=>My::t('app', 'Time').' ('.My::t('app', 'in sec.').'):', 'htmlOptions'=>array('class'=>'field', 'onkeyup'=>'ge(\'item-expire_date\').innerHTML = ajax.send(\'GET\', \'store/ajax/expire/\' + (this.value || 0)).responseText;'), 'appendCode'=>'<span id="item-expire_date" style="margin-left: 7px;"></span>'),
            'reason'=>array('type'=>'textbox', 'title'=>My::t('app', 'Reason').':', 'htmlOptions'=>array('class'=>'field large')),
            'what'=>array('type'=>'radiobuttonlist', 'data'=>$whatList, 'checked'=>'ban', 'htmlOptions'=>array('class'=>'field'))
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