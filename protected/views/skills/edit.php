<?php echo $actionMessage; ?>
<?php if(!empty($skill)): ?>
<div class="subhead"><?php echo $skill['name']; ?> (ID: <?php echo $skill['id'] ?>)</div>
<style>.light-form .field-group {margin-bottom: 5px;} .field-group > label {font-size: 12px;}</style>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'skills/edit/id/'.$skill['id'],
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'save'),
            'id'=>array('type'=>'hidden', 'value'=>$skill['id']),
            'icon'=>array('type'=>'hidden', 'value'=>$skill['icon']),
            'name'=>array('type'=>'textbox', 'title'=>My::t('app', 'Name').':', 'value'=>$skill['name'], 'htmlOptions'=>array('class'=>'field no-shadow')),
            'upload'=>array('type'=>'file', 'title'=>My::t('app', 'Icon').':', 'htmlOptions'=>array('onchange'=>'fileRead(this);')),
            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price').':', 'value'=>$skill['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
            'level'=>array('type'=>'textbox', 'title'=>My::t('app', 'Level').':', 'value'=>$skill['level'], 'htmlOptions'=>array('class'=>'field no-shadow')),
            'progress'=>array('type'=>'textbox', 'title'=>My::t('app', 'Progress').':', 'value'=>$skill['progress'], 'htmlOptions'=>array('class'=>'field no-shadow')),
            'type'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Type').':', 'data'=>array('common'=>My::t('app', 'Common'), 'heaven'=>My::t('app', 'Heaven'), 'hell'=>My::t('app', 'Hell')), 'value'=>$skill['type'], 'htmlOptions'=>array('class'=>'field no-shadow'))
        ),
        'checkboxes'=>array(
            'for_sale'=>array('type'=>'checkbox', 'title'=>My::t('app', 'For sale'), 'checked'=>$skill['for_sale'], 'value'=>'1', 'htmlOptions'=>array('class'=>'checkbox'), 'htmlLabelOptions'=>array('class'=>'icon-checkbox')),
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small blue right-float')),
            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Back'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'style'=>'margin-right: 5px;', 'onclick'=>'window.location.href = \'skills/admin\';'))
        ),
        'return'=>true
    )); ?>
</div>
<script type="text/javascript">function fileRead(elem) { var fr = new FileReader(), i = qs('input[name=\'icon\']'); fr.onloadend = function(event) { i.value = event.target.result; }; fr.readAsDataURL(elem.files[0]); }</script>
<?php endif; ?>