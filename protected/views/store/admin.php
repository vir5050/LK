<?php echo $actionMessage; ?>
<div class="subhead"><?php echo My::t('app', 'List items') ?></div>
<div class="container-wrapper">
    <div class="alert alert-info" style="margin-top: 0">
        <h4>Импорт предметов из elements.data</h4>
        <div class="alert alert-success">Загрузите <strong>import.zip</strong> архив с файлом <strong>UdE_Exported_Table.tab</strong> и папкой <strong>Icons</strong> в директорию <strong><?php echo APP_PATH; ?>/uploads/</strong></div>
        <a href="store/import" style="margin-top: 5px; display: block" class="primary-link">Сделать импорт</a>
    </div>
    <div style="margin-bottom: 7px; text-align: right;">
        <?php echo CHtml::dropDownList('masks', My::app()->getRequest()->getQuery('filterMask'), My::t('app', 'maskNames'), array('class'=>'field small no-hover right-float', 'style'=>'margin-bottom: 5px; width: 200px;', 'onchange'=>'if (this.value != \'\') window.location.href = \'store/admin/filterMask/\' + this.value;')); ?>
        <a href="store/additem" class="primary-link left-float" style="margin-top: 5px;">+ <?php echo My::t('core', 'Add'); ?></a>
    </div>
    <table class="primary-table" style="width: 100%;">
        <tr>
            <th style="width: 30px;text-align:center;" onmouseover="showTooltip(this, '<center>Уникальный идентификатор<br>Используйте его для выдачи наград и призов</center>', {target:this, tipJoint:'bottom', ajax:true, offset:[0, -5]});">UID</th>
            <th style="width: 30px;" onclick="Store.showFilter(this, {padding:2, width:46});"><span>ID <i data-icon="&#xe009;" class="search"></i></span><input type="text" class="no-display" onkeyup="Store.hideFilter(this, event, {padding:'4px 10px', width:30}); if (event.keyCode == 13) { top.location.href = 'store/admin' + (this.value != '' ? ('/filterId/' + this.value) : ''); }" /></th>
            <th style="padding: 0; width: 40px;"></th>
            <th onclick="Store.showFilter(this, {padding:'2px'});"><span>Name <i data-icon="&#xe009;" class="search"></i></span><input type="text" class="no-display" onkeyup="Store.hideFilter(this, event, {padding:'4px 10px'}); if (event.keyCode == 13) { top.location.href = 'store/admin' + (this.value != '' ? ('/filterName/' + this.value) : ''); }" /></th>
            <th style="width: 27px;"><?php echo My::t('app', 'Price'); ?></th>
            <th style="width: 30px; white-space: nowrap;"><?php echo My::t('app', 'Amt'); ?></th>
            <th style="width: 50px; white-space: nowrap;"><?php echo My::t('app', 'For sale'); ?></th>
            <th style="width: 85px;"><?php echo My::t('core', 'Action'); ?></th>
        </tr>
        <?php if(!empty($storeItems)): ?>
            <?php $i = (($currentPage - 1) * $pageSize)+1; ?>
            <?php foreach($storeItems as $item): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td style="padding: 2px 4px;" onclick="qs('input', this).classList.remove('naked'); qs('input', this).focus();"><input style="padding:0; height: 30px; text-align: center;" type="text" class="field naked" value="<?php echo $item['item_id']; ?>" onkeyup="if (event.keyCode == 13) { Store.quickEdit('store/ajax', {sid:<?php echo $item['store_id']; ?>, key:'item_id', val: this.value}, this); } if (event.keyCode == 13 || event.keyCode == 27) { this.classList.add('naked'); this.blur() }" onfocus="showTooltip(this, '<?php echo My::t('app', 'Enter - save; Esc - close'); ?>', {showOn:'click', hideOn:'keydown', tipJoint:'bottom', target:this, offset:[0, -6], removeElementsOnHide:true});" /></td>
                    <td style="padding: 0; text-align: center;"><?php if(file_exists('uploads/Icons/'.$item['item_id'].'.png')) echo '<img src="uploads/Icons/'.$item['item_id'].'.png" height="32px" style="margin-top: 2px; vertical-align: middle;" />'; ?></td>
                    <td style="padding: 0 2px;" onclick="qs('input', this).classList.remove('naked'); qs('input', this).focus();"><input style="padding: 0 3px; height: 30px;" type="text" class="field naked" value="<?php echo $item['name']; ?>" onkeyup="if (event.keyCode == 13) { Store.quickEdit('store/ajax', {sid:<?php echo $item['store_id']; ?>, key:'name', val: this.value}, this); } if (event.keyCode == 13 || event.keyCode == 27) { this.classList.add('naked'); this.blur() }" onfocus="showTooltip(this, '<?php echo My::t('app', 'Enter - save; Esc - close'); ?>', {showOn:'click', hideOn:'keydown', tipJoint:'bottom', target:this, offset:[0, -6], removeElementsOnHide:true});" /></td>
                    <td style="padding: 0 2px;" onclick="qs('input', this).classList.remove('naked'); qs('input', this).focus();"><input style="padding: 0; height: 30px; text-align: center;" type="text" class="field naked" value="<?php echo $item['price']; ?>" onkeyup="if (event.keyCode == 13) { Store.quickEdit('store/ajax', {sid:<?php echo $item['store_id']; ?>, key:'price', val: this.value}, this); } if (event.keyCode == 13 || event.keyCode == 27) { this.classList.add('naked'); this.blur() }" onfocus="showTooltip(this, '<?php echo My::t('app', 'Enter - save; Esc - close'); ?>', {showOn:'click', hideOn:'keydown', tipJoint:'bottom', target:this, offset:[0, -6], removeElementsOnHide:true});" /></td>
                    <td style="padding: 0 2px;" onclick="qs('input', this).classList.remove('naked'); qs('input', this).focus();"><input style="padding: 0; height: 30px; text-align: center;" type="text" class="field naked" value="<?php echo $item['count']; ?>" onkeyup="if (event.keyCode == 13) { Store.quickEdit('store/ajax', {sid:<?php echo $item['store_id']; ?>, key:'count', val: this.value}, this); } if (event.keyCode == 13 || event.keyCode == 27) { this.classList.add('naked'); this.blur() }" onfocus="showTooltip(this, '<?php echo My::t('app', 'Enter - save; Esc - close'); ?>', {showOn:'click', hideOn:'keydown', tipJoint:'bottom', target:this, offset:[0, -6], removeElementsOnHide:true});" /></td>
                    <td style="text-align: center;">
                        <input type="checkbox" class="checkbox" onclick="Store.quickEdit('store/ajax', {sid:<?php echo $item['store_id']; ?>, key:'for_sale', val: isChecked(this)}, this);" id="store-forsale-box-<?php echo $item['store_id']; ?>" <?php echo ($item['for_sale']==0 ? '' : 'checked'); ?>/>
                        <label style="display: inline-block;" for="store-forsale-box-<?php echo $item['store_id']; ?>" class="icon-checkbox"></label>
                    </td>
                    <td>
                        <a onclick="return go(this, event);" class="primary-link" href="store/edit/id/<?php echo $item['store_id']; ?>">Редактирование</a><br />
                        <a class="primary-link" href="javascript:;" onclick="Store.removeItem('store/ajax', {act:'item_remove', sid:<?php echo $item['store_id']; ?>}, getParent(this, false, 'tr'));">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <?php echo CWidget::create('CPagination', array(
        'htmlOptions'=>array('class'=>'pagination right'),
        'targetPath'=>$targetPath,
        'currentPage'=>$currentPage,
        'pageSize'=>$pageSize,
        'totalRecords'=>$totalRecords,
        'events'=>'onclick="return go(this, event);"'
    )); ?>
</div>