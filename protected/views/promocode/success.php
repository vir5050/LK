<div style="text-align: center;">
	<p>Промокод успешно активирован.</p>
	<?php if (!empty($item)): ?><p style="padding-top: 1em">Вы получили предмет <?php echo $item->name; ?></p><?php endif; ?>
	<?php if (!empty($coins)): ?><p style="padding-top: 1em">Вы получили <?php echo $coins; ?> монет</p><?php endif; ?>
	<?php echo $this->actionMessage; ?>
</div>