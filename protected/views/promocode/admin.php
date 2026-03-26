<div class="subhead subpage"><?php echo $this->_pageTitle; ?></div>
<div class="container-wrapper">
	<a href="promocode/add/" data-fancybox data-type="ajax" class="right-float clearfix" style="margin-bottom: 15px;" data-fancybox>Добавить новый промокод</a>
	<?php echo $this->actionMessage; ?>
	<?php if (!empty($promocodes)): ?>
	<table class="primary-table">
		<tr>
			<th>Промокод</th>
			<th>Предмет</th>
			<th>Монеты</th>
			<th>Многоразовый</th>
			<th>Создан</th>
			<th><?php echo My::t('core', 'Action'); ?></th>
		</tr>
		<?php foreach ($promocodes as $promocode): ?>
		<?php $item = Store::model()->findByPk($promocode['store_id']); ?>
		<tr>
			<td data-src="promocode/history/id/<?php echo $promocode['id']; ?>" data-type="ajax" data-fancybox><?php echo $promocode['code']; ?></td>
			<td style="text-align: left;"><?php if ($item!==null): ?><a onmouseover="showTooltip(this, 'Preview', {target:this, tipJoint:'bottom', ajax:true, offset:[0, -10]});" href="store/preview/store_id/<?php echo $item->store_id; ?>"><img src="uploads/Icons/<?php echo $item->item_id; ?>.png" style="vertical-align: middle;" /> x<?php echo $promocode['count']; ?></a><?php endif; ?></td>
			<td style="width:1px"><?php echo $promocode['coins']; ?></td>
			<td style="width:1px"><?php echo ($promocode['reusable'] == 1 ? 'Да' : 'Нет'); ?></td>
			<td style="width:1px; white-space: nowrap;"><?php echo CTime::makePretty($promocode['created_at'], 'abbreviated', false); ?></td>
			<td style="width: 1px; white-space: nowrap;">
				<a href="promocode/edit/id/<?php echo $promocode['id']; ?>" data-fancybox data-type="ajax">Изменить</a>	/
				<a onclick="Store.removeItem('promocode/admin', {act:'remove', id:<?php echo $promocode['id']; ?>}, getParent(this, false, 'tr'));" href="javascript:;"><?php echo My::t('app', 'Delete'); ?></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>