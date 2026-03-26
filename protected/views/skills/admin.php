<div class="subhead"><?php echo My::t('app', 'List of skills'); ?></div>
<div class="container-wrapper">
    <?php echo $actionMessage; ?>
    <?php if(!empty($skills)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th style="width: 30px;" onclick="Store.showFilter(this, {padding:2, width:46});"><span>ID <i data-icon="&#xe009;" class="search"></i></span><input type="text" class="no-display" onkeyup="Store.hideFilter(this, event, {padding:'4px 10px', width:30}); if (event.keyCode == 13) { top.location.href = 'skills/admin' + (this.value != '' ? ('/filterId/' + this.value) : ''); }" /></th>
                <th onclick="Store.showFilter(this, {padding:'2px'});"><span>Name <i data-icon="&#xe009;" class="search"></i></span><input type="text" class="no-display" onkeyup="Store.hideFilter(this, event, {padding:'4px 10px'}); if (event.keyCode == 13) { top.location.href = 'skills/admin' + (this.value != '' ? ('/filterName/' + this.value) : ''); }" /></th>
                <th style="width: 50px; text-align: center;"><?php echo My::t('app', 'Level'); ?></th>
                <th style="width: 50px; text-align: center;"><?php echo My::t('app', 'Price'); ?></th>
                <th style="width: 50px;"><?php echo My::t('core', 'Action'); ?></th>
            </tr>
            <?php foreach($skills as $skill): ?>
                <tr>
                    <td><?php echo $skill['id']; ?></td>
                    <td><img src="<?php echo (!empty($skill['icon']) ? $skill['icon'] : 'templates/default/images/0.gif'); ?>" width="20" height="20" style="display: inline-block; vertical-align: middle;" /> <span style="margin-left: 5px; display: inline-block; vertical-align: middle; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; width: 255px;"><?php echo $skill['name']; ?></span></td>
                    <td style="text-align: center;"><?php echo $skill['level']; ?></td>
                    <td style="text-align: center;"><?php echo $skill['price']; ?></td>
                    <td style="white-space: nowrap;"><a class="primary-link" href="skills/edit/id/<?php echo $skill['id']; ?>"><?php echo My::t('app', 'Edit'); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords,
            'events'=>'onclick="return go(this, event);"'
        )); ?>
    <?php endif; ?>
</div>