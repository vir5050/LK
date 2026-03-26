<div class="subhead">
    <a class="active" href="account/allactivity" onclick="return go(this, event);"><i data-icon="&#xe1b5;"></i> <?php echo My::t('app', 'All Activity'); ?></a>
    <a href="account/storeactivity" onclick="return go(this, event);"><i data-icon="&#xe093;"></i> <?php echo My::t('app', 'Store Activity'); ?></a>
    <a href="account/serviceactivity" onclick="return go(this, event);"><i data-icon="&#xe205;"></i> <?php echo My::t('app', 'Service Activity'); ?></a>
    <a href="account/paymentsactivity/system/freekassa" onclick="return go(this, event);"><i data-icon="&#xe39f;"></i> <?php echo My::t('app', 'Payments Activity'); ?></a>
</div>
<div class="container-wrapper">
    <?php if(count($allActivity) > 0): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th>#</th>
                <th><?php echo My::t('core', 'Action'); ?></th>
                <th><?php echo My::t('core', 'IP Address'); ?></th>
                <th><?php echo My::t('core', 'Date and time'); ?></th>
                <th><?php echo My::t('core', 'Request data'); ?></th>
            </tr>
            <?php $i = (($currentPage - 1) * $pageSize)+1; ?>
            <?php foreach($allActivity as $log): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo My::t('app', $_urlAction[$log['request_url']]); ?></td>
                    <td><?php echo CIp::convertIpBinaryToString($log['ip_address']); ?></td>
                    <td><?php echo CTime::makePretty($log['request_date']); ?></td>
                    <td style="text-transform: lowercase;"><?php
                        $data = json_decode($log['request_data']);
                        if(is_object($data)){
                            echo My::t('app', 'Attempts').': '.(!$data->loginAttempts ? 0 : $data->loginAttempts).', '.My::t('app', 'From cookie').': '.$data->fromCookie.', '.My::t('app', 'Remember').': '.$data->remember;
                        }
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