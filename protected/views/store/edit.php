<div class="subhead"><?php echo $item['name']; ?> (ID: <?php echo $item['item_id'] ?>)</div>
<?php echo $actionMessage; ?>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'store/edit/id/'.$item['store_id'],
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'save'),
            'store_id'=>array('type'=>'hidden', 'value'=>$item['store_id']),
            'name'=>array('type'=>'textbox', 'title'=>My::t('app', 'Item name').':', 'value'=>$item['name'], 'htmlOptions'=>array('class'=>'field')),
            'description'=>array('type'=>'textarea', 'title'=>My::t('app', 'Description').':', 'value'=>$item['description'], 'htmlOptions'=>array('class'=>'field large', 'style'=>'padding: 5px; height: 50px;')),
            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price').':', 'value'=>$item['price'], 'htmlOptions'=>array('class'=>'field')),
            'discount'=>array('type'=>'textbox', 'title'=>My::t('app', 'Discount').':', 'value'=>$item['discount'], 'htmlOptions'=>array('class'=>'field')),
            'count'=>array('type'=>'textbox', 'title'=>My::t('app', 'Count').':', 'value'=>$item['count'], 'htmlOptions'=>array('class'=>'field')),
            'max_count'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. count').':', 'value'=>$item['max_count'], 'htmlOptions'=>array('class'=>'field')),
            'octet'=>array('type'=>'textbox', 'title'=>My::t('app', 'Octet').':', 'value'=>$item['octet'], 'htmlOptions'=>array('class'=>'field large')),
            'mask'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Mask').':', 'data'=>My::t('app', 'maskNames'), 'value'=>$item['mask'], 'htmlOptions'=>array('class'=>'field')),
            'proctype'=>array('type'=>'textbox', 'title'=>My::t('app', 'Proctype').' (<b>Esc</b> - close):', 'value'=>$item['proctype'], 'htmlOptions'=>array('class'=>'field', 'onfocus'=>'showTooltip(this, ge(\'ipt\').innerHTML, {showOn:\'click\', hideOn:\'keydown\', tipJoint:\'left\', target: ge(\'ipt\'), offset:[10, -5]}); ge(\'ipt\').innerHTML = \'\';'), 'appendCode'=>'<ot id="ipt">'.$this->itemProctype.'</ot>'),
            'expire_date'=>array('type'=>'textbox', 'title'=>My::t('app', 'Expire date').' ('.My::t('app', 'in sec.').'):', 'value'=>$item['expire_date'], 'htmlOptions'=>array('class'=>'field', 'onkeyup'=>'ge(\'item-expire_date\').innerHTML = ajax.send(\'GET\', \'store/ajax/expire/\' + (this.value || 0)).responseText;'), 'appendCode'=>'<span id="item-expire_date" style="margin-left: 7px;"></span>'),
            'category'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Category').':', 'data'=>$categories, 'value'=>$item['category'], 'htmlOptions'=>array('class'=>'field'))
        ),
        'checkboxes'=>array(
            'count_editable'=>array('type'=>'checkbox', 'title'=>My::t('app', 'Count editable'), 'checked'=>$item['count_editable'], 'value'=>'1', 'htmlOptions'=>array('class'=>'checkbox'), 'htmlLabelOptions'=>array('class'=>'icon-checkbox')),
            'shareable'=>array('type'=>'checkbox', 'title'=>My::t('app', 'Shareable'), 'checked'=>$item['shareable'], 'value'=>'1', 'htmlOptions'=>array('class'=>'checkbox'), 'htmlLabelOptions'=>array('class'=>'icon-checkbox')),
            'for_sale'=>array('type'=>'checkbox', 'title'=>My::t('app', 'For sale'), 'checked'=>$item['for_sale'], 'value'=>'1', 'htmlOptions'=>array('class'=>'checkbox'), 'htmlLabelOptions'=>array('class'=>'icon-checkbox'))
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small blue right-float')),
            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Back'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'style'=>'margin-right: 5px;', 'onclick'=>'window.location.href = \'store/admin\';'))
        ),
        'return'=>true
    )); ?>
</div>