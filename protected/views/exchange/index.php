<div class="subhead"><?php echo My::t('app', 'Exchange coins for cubigold'); ?></div>
<div class="container-wrapper">
	<?php if(!isset($offline)): ?>
		<ul class="ui-list" style="margin: 0 30px 10px;">
			<li><?php echo My::t('app', 'Per one day you can only buy {max} gold', array('{max}'=>$max)); ?></li>
			<li><?php echo My::t('app', 'Available to you {current} of {max}', array('{current}'=>$current, '{max}'=>$max)); ?></li>
			<li><?php echo My::t('app', 'Price for 1 gold - {price}', array('{price}'=>($price > 0) ? $price : My::t('app', 'Free'))); ?></li>
		</ul>
		<?php echo CWidget::create('CFormView', array(
			'action'=>'exchange/',
			'method'=>'post',
			'htmlOptions'=>array(
				'name'=>'service-form',
				'class'=>'light-form inline-label',
				'style'=>'float: none;',
				'onkeypress'=>'if (event.keyCode == 13) return false;'
			),
			'fields'=>array(
				'act' =>array('type'=>'hidden', 'value'=>'send'),
				'count'=>array('type'=>'textbox', 'title'=>My::t('app', 'Enter count:'), 'htmlOptions'=>array('id'=>'gold-count', 'class'=>'field small', 'autocomplete'=>'off')),
			),
			'buttons'=>array(
				'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Confirm operation'), 'htmlOptions'=>array('class'=>'button blue-gradient'.($repeat===null ? '' : ' disabled'), 'onclick'=>'this.classList.add(\'disabled\');'), 'appendCode'=>($repeat===null ? '' : My::t('app', 'You can repeat this operation {time}', array('{time}'=>$repeat)))),
			),
			'events'=>array(
				'focus'=>array('field'=>$errorField)
			),
			'return'=>true,
		)); ?>
	<?php endif; ?>
	<?php echo $this->actionMessage; ?>
</div>
<?php if(!empty($usecashnow)): ?>
<div class="subhead">Ваши последние обмены</div>
<div class="container-wrapper">
	<table class="primary-table" style="width: 100%;">
		<tr>
			<th>#</th>
			<th>Количество золотых</th>
			<th>Время</th>
			<th>Статус</th>
		</tr>
		<?php foreach($usecashnow as $key => $value): ?>
		<tr>
			<td><?php echo $key+1; ?></td>
			<td><?php echo $value['cash'] / 100; ?></td>
			<td><?php echo CTime::makePretty(strtotime($value['creatime'])); ?></td>
			<td>В обработке</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php endif; ?>