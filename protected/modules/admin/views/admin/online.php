<script type="text/javascript" src="js/vendors/tablesort.js"></script>
<div class="subhead"><?php echo My::t('app', 'Online characters'); ?></div>
<div class="container-wrapper">
    <?php if(!empty($online)): ?>
        <table class="primary-table" style="width: 100%;" id="tableSort">
            <tr>
                <th>#</th>
                <th style="width: 10px;"><?php echo My::t('app', 'UID'); ?></th>
                <th class="no-sort"><?php echo My::t('app', 'Character'); ?></th>
                <th class="no-sort" style="width: 10px;"><?php echo My::t('app', 'link'); ?></th>
                <th class="no-sort" style="width: 10px;"><?php echo My::t('app', 'lsid'); ?></th>
                <th><?php echo My::t('app', 'Location'); ?></th>
                <th><?php echo My::t('app', 'Login IP'); ?></th>
                <th><?php echo My::t('app', 'Login time'); ?></th>
            </tr>
            <?php foreach($online as $key => $role): ?>
                <tr>
                    <td><?php echo ($key + 1); ?></td>
                    <td><?php echo $role['userid']; ?></td>
                    <td><?php echo $role['roleid']; ?> - <?php echo $role['name']; ?></td>
                    <td><?php echo $role['linkid']; ?></td>
                    <td><?php echo $role['localsid']; ?></td>
                    <td><?php echo My::t('dungeon', 'id.'.$role['gsid']); ?></td>
                    <td data-sort="<?php echo (isset($role['login_ip']) ? $role['login_ip'] : 0); ?>" style="background-color: <?php echo (isset($role['login_ip']) ? CIp::convertIpToColor(long2ip($role['login_ip'])) : 'transparent'); ?>; color: rgb(255, 255, 255);"><?php echo (isset($role['login_ip']) ? long2ip($role['login_ip']) : '-'); ?></td>
                    <td data-sort="<?php echo (isset($role['login_time']) ? $role['login_time'] : 0); ?>"><?php echo (isset($role['login_time']) ? CTime::makePretty($role['login_time']) : '-'); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<script type="text/javascript">new Tablesort(document.getElementById('tableSort'));</script>