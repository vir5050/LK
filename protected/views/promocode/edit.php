<?php echo CWidget::create('CFormView', [
	'action'=>'promocode/edit/id/'.$promocode->id,
	'method'=>'post',
	'htmlOptions'=>[
		'class'=>'clearfix',
		'onsubmit'=>'return buildAjaxRequest(this, event)',
		'style'=>'background-color: rgba(255, 255, 255, 0.15); width: 520px; margin: 0 auto; text-align: center;',
	],
	'fields'=>[
		'act'=>['type'=>'hidden', 'value'=>'send'],
		'coins'=>['type'=>'textbox', 'value'=>$promocode->coins, 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto', 'placeholder'=>My::t('app', 'Количество монет')]],
		'store_id'=>['type'=>'textbox', 'value'=>$promocode->store_id, 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto', 'placeholder'=>My::t('app', 'Item from store')]],
		'count'=>['type'=>'textbox', 'value'=>$promocode->count, 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto', 'placeholder'=>My::t('app', 'Count')]],
		'code'=>['type'=>'textbox', 'value'=>$promocode->code, 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto'], 'appendCode'=>'<a onclick="randomString(this)" class="field-link">Сгенерировать</a>'],
	],
	'checkboxes'=>[
		'reusable'=>['type'=>'checkbox', 'title'=>My::t('app', 'Многоразовый'), 'value'=>'1', 'checked'=>($promocode->reusable == 1 ? true : false), 'htmlOptions'=>['class'=>'checkbox'], 'htmlLabelOptions'=>['class'=>'icon-checkbox']],
		'status'=>['type'=>'checkbox', 'title'=>My::t('app', 'Активен'), 'value'=>'1', 'checked'=>($promocode->status == 1 ? true : false), 'htmlOptions'=>['class'=>'checkbox'], 'htmlLabelOptions'=>['class'=>'icon-checkbox']],
	],
	'buttons'=>[
		'button'=>['type'=>'submit', 'value'=>'Сохранить', 'htmlOptions'=>['class'=>'button', 'style'=>'margin: 0 auto']]
	]
]); ?>