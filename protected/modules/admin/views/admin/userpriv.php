<div class="subhead"><?php echo My::t('app', 'Управление привилегиями'); ?></div>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'admin/userPriv',
        'method'=>'post',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'act'=>array('type'=>'hidden', 'value'=>'send'),
            'id'=>array('type'=>'textbox', 'title'=>My::t('app', 'Account ID').':', 'htmlOptions'=>array('class'=>'field')),
            'what'=>array('type'=>'radiobuttonlist', 'data'=>$whatList, 'htmlOptions'=>array('class'=>'field'))
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
<div class="subhead"><?php echo My::t('app', 'List of users'); ?></div>
<div class="container-wrapper">
    <?php if(!empty($GMList)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th style="width: 100px;"><?php echo My::t('app', 'Account ID'); ?></th>
                <th><?php echo My::t('app', 'Zone ID'); ?></th>
                <th><?php echo My::t('app', 'Action'); ?></th>
            </tr>
            <?php foreach($GMList as $gm): ?>
                <tr>
                    <td style="text-align:center;"><?php echo $gm['userid']; ?></td>
                    <td><?php echo $gm['zoneid']; ?></td>
                    <td style="width: 50px;"><a href="admin/userPriv/removePriv/<?php echo $gm['userid']; ?>"><?php echo My::t('app', 'Delete'); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>