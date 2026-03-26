<?php echo $actionMessage; ?>
<?php if(isset($roleData) and !empty($roleData)): ?>
    <div class="subhead"><?php echo $roleData['base']['id']; ?> - <?php echo $roleData['base']['name']; ?></div>
    <div class="container-wrapper">
        <?php echo CWidget::create('CFormView', array(
            'action'=>'admin/role-edit/id/'.$roleId,
            'method'=>'post',
            'htmlOptions'=>array(
                'name'=>'loginForm',
                'id'=>'primaryForm',
                'onkeypress'=>'if (event.keyCode == 13) return cancelEvent(event);'
            ),
            'fields'=>array(
                'act'=>array('type'=>'hidden', 'value'=>'save'),
                'roleData'=>array('type'=>'textarea', 'value'=>CHtml::jsonpp(json_encode($roleData)), 'htmlOptions'=>array('class'=>'field no-hover', 'style'=>'height: 500px; resize: none;', 'wrap'=>'off')),
            ),
            'buttons'=>array(
                'button'=>array('type'=>'button', 'value'=>My::t('core', 'Back'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'style'=>'margin-right: 5px; height: 31px; line-height: 31px;', 'onclick'=>'window.location.href = \'admin/roleedit\';')),
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button blue-gradient right-float', 'onclick'=>'this.style.pointerEvents = \'none\''))
            ),
            'events'=>array(
                'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
            ),
            'return'=>true,
        )); ?>
    </div>
<?php else: ?>
    <div class="subhead"><?php echo My::t('app', 'Character editor'); ?></div>
    <div class="container-wrapper">
        <?php echo CWidget::create('CFormView', array(
            'action'=>'admin/role-edit',
            'method'=>'get',
            'htmlOptions'=>array(
                'name'=>'settings-form',
                'class'=>'light-form',
                'style'=>'float: none;'
            ),
            'fields'=>array(
                'id'=>array('type'=>'textbox', 'title'=>My::t('app', 'ID or role name'), 'htmlOptions'=>array('class'=>'field no-shadow'))
            ),
            'buttons'=>array(
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Send'), 'htmlOptions'=>array('class'=>'button blue-gradient right-float'))
            ),
            'events'=>array(
                'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
            ),
            'return'=>true
        )); ?>
    </div>
<?php endif; ?>