<?php if (!empty($promocodes)): ?>
	<div style="width: 500px; background-color: rgba(255, 255, 255, 0.1)">
	<table class="primary-table" style="width: 100%;">
		<tr>
			<th>ID</th>
			<th>Логин</th>
			<th>Активирован</th>
		</tr>
		<?php foreach ($promocodes as $promocode): ?>
		<tr>
			<td style="text-align: center; font-size: 16px; padding: 5px 10px; width: 1px;"><?php echo $promocode['user_id']; ?></td>
			<td style="text-align: center; font-size: 16px; padding: 5px 10px;"><?php echo $promocode['username']; ?></td>
			<td style="text-align: center; width: 1px; padding: 5px 10px; white-space: nowrap; font-size: 16px;"><?php echo CTime::makePretty($promocode['activated_at']); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
	<?php echo CWidget::create('CPagination', [
            'htmlOptions'=>['class'=>'pagination right'],
            'targetPath'=>$targetPath,
            'currentPage'=>$currentPage,
            'pageSize'=>$pageSize,
            'totalRecords'=>$totalRecords,
            'showTotal'=>false,
            'events'=>'onclick="return go(this, event);"'
		]); ?>
<?php else: ?>
	Промокод еще не использовали
<?php endif; ?>