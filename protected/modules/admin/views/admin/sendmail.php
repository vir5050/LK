<div class="subhead"><?php echo My::t('app', 'Send mail to game'); ?></div>
<?php echo $actionMessage; ?>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'admin/sendmail',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'send'),
            'receiver'=>array('type'=>'textbox', 'title'=>My::t('app', 'Receiver').' ('.My::t('app', 'separate by comma').'):', 'htmlOptions'=>array('class'=>'field large')),
            'sendtype'=>array('type'=>'radiobuttonlist', 'data'=>$sendTypesList, 'checked'=>'listed', 'htmlOptions'=>array('class'=>'field purple')),
            'title'=>array('type'=>'textbox', 'title'=>My::t('app', 'Title').':', 'htmlOptions'=>array('class'=>'field')),
            'context'=>array('type'=>'textarea', 'title'=>My::t('app', 'Message').':', 'htmlOptions'=>array('class'=>'field large', 'style'=>'padding: 5px; height: 50px;')),
            'item_id'=>array('type'=>'textbox', 'title'=>My::t('app', 'Item id').':', 'htmlOptions'=>array('class'=>'field')),
            'count'=>array('type'=>'textbox', 'title'=>My::t('app', 'Count').':', 'htmlOptions'=>array('class'=>'field')),
            'max_count'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. count').':', 'htmlOptions'=>array('class'=>'field')),
            'octet'=>array('type'=>'textbox', 'title'=>My::t('app', 'Octet').':', 'htmlOptions'=>array('class'=>'field')),
            'proctype'=>array('type'=>'textbox', 'title'=>My::t('app', 'Proctype').' (<b>Esc</b> - close):', 'htmlOptions'=>array('class'=>'field', 'onfocus'=>'showTooltip(this, ge(\'ipt\').innerHTML, {showOn:\'click\', hideOn:\'keydown\', tipJoint:\'left\', target: ge(\'ipt\'), offset:[10, -5]}); ge(\'ipt\').innerHTML = \'\';'), 'appendCode'=>'<ot id="ipt">'.$itemProctype.'</ot>'),
            'expire_date'=>array('type'=>'textbox', 'title'=>My::t('app', 'Expire date').' ('.My::t('app', 'in sec.').'):', 'htmlOptions'=>array('class'=>'field', 'onkeyup'=>'ge(\'item-expire_date\').innerHTML = ajax.send(\'GET\', \'store/ajax/expire/\' + (this.value || 0)).responseText;'), 'appendCode'=>'<span id="item-expire_date" style="margin-left: 7px;"></span>'),
            'mask'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Mask').':', 'data'=>My::t('app', 'maskNames'), 'htmlOptions'=>array('class'=>'field'))
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