<div class="subhead">
    <a class="<?php echo ($type == 'common' ? 'active': ''); ?>" href="skills/index/type/common" onclick="return go(this, event);"><?php echo My::t('app', 'Common'); ?></a>
    <a class="<?php echo ($type == 'heaven' ? 'active': ''); ?>" href="skills/index/type/heaven" onclick="return go(this, event);"><?php echo My::t('app', 'Heaven'); ?></a>
    <a class="<?php echo ($type == 'hell' ? 'active': ''); ?>" href="skills/index/type/hell" onclick="return go(this, event);"><?php echo My::t('app', 'Hell'); ?></a>
</div>
<div class="container-wrapper">
    <?php echo CWidget::create('CMessage', array('info', My::t('app', 'The selected character must be offline'), array('style'=>'margin-top: 0;'))); ?>
    <?php echo $actionMessage; ?>
    <?php if(!isset($offline) and !empty($skills)): ?>
        <?php echo CWidget::create('CFormView', array(
            'action'=>$targetPath,
            'method'=>'post',
            'htmlOptions'=>array(
                'name'=>'skill-form',
                'class'=>'no-display'
            ),
            'fields'=>array(
                'act'=>array('type'=>'hidden', 'value'=>'buy'),
                'skillId'=>array('type'=>'hidden')
            ),
            'return'=>true,
        )); ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th><?php echo My::t('app', 'Name'); ?></th>
                <th style="width: 50px; text-align: center;"><?php echo My::t('app', 'Level'); ?></th>
                <th style="width: 50px; text-align: center;"><?php echo My::t('app', 'Price'); ?></th>
                <th style="width: 50px; text-align: center;"><?php echo My::t('core', 'Action'); ?></th>
            </tr>
            <?php foreach($skills as $skill): ?>
                <tr>
                    <td><img src="<?php echo (!empty($skill['icon']) ? $skill['icon'] : 'templates/default/images/0.gif'); ?>" width="20" height="20" style="display: inline-block; vertical-align: middle;" /> <span style="margin-left: 5px; display: inline-block; vertical-align: middle;"><?php echo $skill['name']; ?></span></td>
                    <td style="text-align: center;"><?php echo $skill['level']; ?></td>
                    <td style="text-align: center;"><?php echo $skill['price']; ?></td>
                    <td style="text-align: center;"><a class="primary-link" href="javascript:;" onclick="setSkillId(<?php echo $skill['id']; ?>);"><?php echo My::t('app', 'Buy'); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords,
            'showTotal'=>false,
            'events'=>'onclick="return go(this, event);"'
        )); ?>
    <?php endif; ?>
</div>