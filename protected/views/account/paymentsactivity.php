<div class="subhead">
    <a href="account/allactivity" onclick="return go(this, event);"><i data-icon="&#xe1b5;"></i> <?php echo My::t('app', 'All Activity'); ?></a>
    <a href="account/storeactivity" onclick="return go(this, event);"><i data-icon="&#xe093;"></i> <?php echo My::t('app', 'Store Activity'); ?></a>
    <a href="account/serviceactivity" onclick="return go(this, event);"><i data-icon="&#xe205;"></i> <?php echo My::t('app', 'Service Activity'); ?></a>
    <a class="active" href="account/paymentsactivity/system/freekassa" onclick="return go(this, event);"><i data-icon="&#xe39f;"></i> <?php echo My::t('app', 'Payments Activity'); ?></a>
</div>
<p style="padding-top: 2px;">
    <a style="font-size: 11px;" class="primary-link" href="account/paymentsactivity/system/freekassa" onclick="return go(this, event);">Free-Kassa</a> &bull;
    <a style="font-size: 11px;" class="primary-link" href="account/paymentsactivity/system/waytopay" onclick="return go(this, event);">Way to Pay</a>
</p>
<div class="container-wrapper">
    <?php if(!empty($fkActivity)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th>#</th>
                <th><?php echo My::t('app', 'Amount'); ?></th>
                <th><?php echo My::t('app', 'Result amount'); ?></th>
                <th><?php echo My::t('core', 'IP Address'); ?></th>
                <th><?php echo My::t('app', 'Email'); ?></th>
                <th><?php echo My::t('core', 'Date and time'); ?></th>
                <th><?php echo My::t('core', 'Complete'); ?></th>
            </tr>
            <?php $i = (($currentPage - 1) * $pageSize)+1; ?>
            <?php foreach($fkActivity as $pay): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo My::t('app', $pay['amount']); ?></td>
                    <td><?php echo My::t('app', $pay['result_amount']); ?></td>
                    <td><?php echo CIp::convertIpBinaryToString($pay['ip_address']); ?></td>
                    <td><?php echo CEmail::shorten($pay['email']); ?></td>
                    <td><?php echo CTime::makePretty($pay['request_date'], 'abbreviated'); ?></td>
                    <td><?php echo CTime::makePretty($pay['complete_date'], 'abbreviated'); ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords
        )); ?>
    <?php endif; ?>
    <?php if(!empty($wpActivity)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th>#</th>
                <th><?php echo My::t('app', 'Amount'); ?></th>
                <th><?php echo My::t('app', 'Result amount'); ?></th>
                <th><?php echo My::t('core', 'IP Address'); ?></th>
                <th><?php echo My::t('core', 'Date and time'); ?></th>
                <th><?php echo My::t('core', 'Complete'); ?></th>
            </tr>
            <?php $i = (($currentPage - 1) * $pageSize)+1; ?>
            <?php foreach($wpActivity as $pay): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo My::t('app', $pay['amount']); ?></td>
                    <td><?php echo My::t('app', $pay['result_amount']); ?></td>
                    <td><?php echo CIp::convertIpBinaryToString($pay['ip_address']); ?></td>
                    <td><?php echo CTime::makePretty($pay['request_date'], 'abbreviated'); ?></td>
                    <td><?php echo CTime::makePretty($pay['complete_date'], 'abbreviated'); ?></td>

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