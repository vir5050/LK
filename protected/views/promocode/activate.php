<div class="subhead subpage" style="width: 100%;padding-bottom: 20px;
font-family: Beaufort Bold;text-transform: uppercase;
font-size: 25px;color: #562200;text-align: center;top: 10px;
position: relative;"><?php echo $this->_pageTitle; ?></div>
<div class="container-wrapper">
<?php 
error_reporting(0);
if(empty($RESULT)){
}
else {
$error = <<<HTML
			<div class="alert alert-info">
				<center>$RESULT</center>
			</div>
HTML;
}
?>
<?php echo $error; ?>

	<?php if (!empty($item)): ?>
	<div class="alert alert-success">
	<p style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;">Вы получили предмет <?php echo $item->name; ?></p>
	</div>
	<?php endif; ?>
	<?php if (!empty($coins)): ?>
	<div class="alert alert-success">
	<p style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;">Вы получили <?php echo $coins; ?> монет</p>
	</div>
	<?php endif; ?>
<i data-icon="&#xe37c;" style="text-align: center;color: #e55454;display: block;font-size: 90px;"></i>

<li style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;margin-top: 15px;">Промокод длинной в 25 символов в цифро-буквенном формате.</li><br /><br />
	<?php echo CWidget::create('CFormView', [
		'action'=>'promocode/activate/',
		'method'=>'post',
		'htmlOptions'=>[
			'class'=>'clearfix',
			'onsubmit'=>'return buildAjaxRequest(this, event)',
		],
		'fields'=>[
			'activate'=>['type'=>'hidden', 'value'=>'1'],
			'code'=>['type'=>'textbox', 'htmlOptions'=>['class'=>'field2 transition', 'placeholder'=>My::t('app', 'Введите промокод'), 'required'=>'required', 'pattern'=>'[a-zA-Z0-9]+$', 'minlength'=>25, 'maxlength'=>25]]
		],
		'buttons'=>[
			'button'=>['type'=>'submit', 'value'=>'Активировать', 'htmlOptions'=>['style'=>'position: relative;text-align: center; width: 200px; height: 40px', 'class'=>'b-page-header__person2']]
		]
	]); ?>
</div>