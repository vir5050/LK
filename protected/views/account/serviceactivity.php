<div class="subhead">
    <a href="account/allactivity" onclick="return go(this, event);"><i data-icon="&#xe1b5;"></i> <?php echo My::t('app', 'All Activity'); ?></a>
    <a href="account/storeactivity" onclick="return go(this, event);"><i data-icon="&#xe093;"></i> <?php echo My::t('app', 'Store Activity'); ?></a>
    <a class="active" href="account/serviceactivity" onclick="return go(this, event);"><i data-icon="&#xe205;"></i> <?php echo My::t('app', 'Service Activity'); ?></a>
    <a href="account/paymentsactivity/system/freekassa" onclick="return go(this, event);"><i data-icon="&#xe39f;"></i> <?php echo My::t('app', 'Payments Activity'); ?></a>
</div>
<div class="container-wrapper">
    <?php if(count($serviceActivity) > 0): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th>#</th>
                <th><?php echo My::t('core', 'Item'); ?></th>
                <th><?php echo My::t('core', 'IP Address'); ?></th>
                <th><?php echo My::t('core', 'Date and time'); ?></th>
                <th><?php echo My::t('core', 'Request data'); ?></th>
            </tr>
            <?php $i = (($currentPage - 1) * $pageSize)+1; ?>
            <?php foreach($serviceActivity as $log): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $log['service_id']; ?></td>
                    <td><?php echo CIp::convertIpBinaryToString($log['ip_address']); ?></td>
                    <td><?php echo CTime::makePretty($log['request_date']); ?></td>
                    <td style="text-transform: lowercase;"><?php
                        $data = json_decode($log['request_data']);
                        echo (isset($data->roleid) ? My::t('app', 'Character').': '.$data->roleid.', ': '').(isset($data->count) ? My::t('app', 'Count').': '.$data->count.', ' : '').(isset($data->price) ? My::t('app', 'Price').': '.$data->price : '');
                        ?></td>
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