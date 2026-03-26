<div class="subhead"><?php echo My::t('app', 'Submitting a faction logo'); ?></div>
<div class="container-wrapper">
    <div style="margin-top: 0;" class="alert alert-info">
        <?php echo My::t('core', 'Put files'); ?> <strong>iconlist_guild.txt</strong> <?php echo My::t('core', 'and'); ?> <strong>iconlist_guild.png</strong> <?php echo My::t('core', 'to'); ?> <strong>/guildicons</strong>
        <ul class="ui-list" style="margin: 10px 20px 0;">
            <li style="padding: 0;"><a class="primary-link" href="icon/admin/step/parse"><?php echo My::t('app', 'Parse icon file'); ?></a></li>
            <li style="padding: 0;"><a class="primary-link" href="icon/admin/step/save"><?php echo My::t('app', 'Save icon file'); ?></a></li>
        </ul>
    </div>
    <?php echo $actionMessage; ?>
    <?php if(!empty($icons)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th style="width: 20px; text-align: center;">#</th>
                <th style="width: 40px; text-align: center;">ID</th>
                <th><?php echo My::t('app', 'Name'); ?></th>
                <th><?php echo My::t('app', 'Character'); ?></th>
                <th><?php echo My::t('app', 'Account ID'); ?></th>
                <th><?php echo My::t('core', 'Request date'); ?></th>
                <th style="width: 50px;"><?php echo My::t('core', 'Action'); ?></th>
            </tr>
            <?php $i = (($currentPage - 1) * $pageSize)+1; ?>
            <?php foreach($icons as $icon): ?>
                <tr>
                    <td style="text-align: center;"><?php echo $i; ?></td>
                    <td style="text-align: center;"><?php echo $icon['faction_id']; ?></td>
                    <td><img style="vertical-align: middle;" src="guildicons/<?php echo $icon['faction_id']; ?>.png" /> <?php echo $icon['faction_name']; ?></td>
                    <td><?php echo $icon['role_name']; ?> (<?php echo $icon['role_id']; ?>)</td>
                    <td><?php echo $icon['account_id']; ?></td>
                    <td><?php echo CTime::makePretty($icon['request_date']); ?></td>
                    <td style="text-align: center">
                        <a class="primary-link" href="javascript:;" onclick="Store.removeItem('icon/admin', {act:'remove', id:<?php echo $icon['id']; ?>}, getParent(this, false, 'tr'));"><?php echo My::t('app', 'Delete'); ?></a>
                    </td>
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
<script type="text/javascript">function setSkillId(id) { var f = qs('form[name=\'skill-form\']'), s = qs('input[name=\'skillId\']', f); s.value = id; if (confirm('<?php echo My::t('app', 'Confirm operation'); ?>')) { f.submit(); } }</script>