<?php echo CWidget::create('CFormView', [
	'action'=>'promocode/add/',
	'method'=>'post',
	'htmlOptions'=>[
		'class'=>'clearfix',
		'onsubmit'=>'return buildAjaxRequest(this, event)',
		'style'=>'background-color: rgba(255, 255, 255, 0.15); width: 520px; margin: 0 auto; text-align: center;',
	],
	'fields'=>[
		'act'=>['type'=>'hidden', 'value'=>'send'],
		'coins'=>['type'=>'textbox', 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto', 'placeholder'=>My::t('app', 'Количество монет')]],
		'store_id'=>['type'=>'textbox', 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto', 'placeholder'=>My::t('app', 'Item from store')]],
		'count'=>['type'=>'textbox', 'htmlOptions'=>['class'=>'field large', 'style'=>'margin: 0 auto', 'placeholder'=>My::t('app', 'Count')]],
		'code'=>['value'=>'', 'type'=>'textbox', 'htmlOptions'=>['class'=>'field large', 'id'=>'randomfield', 'style'=>'margin: 0 auto'], 'appendCode'=>'<a onClick="randomString(this)" class="field-link">Сгенерировать</a>'],
	],
	'checkboxes'=>[
		/**'reusable'=>['type'=>'checkbox', 'title'=>My::t('app', 'Многоразовый'), 'value'=>'1', 'htmlOptions'=>['class'=>'checkbox'], 'htmlLabelOptions'=>['class'=>'icon-checkbox']],**/
		'status'=>['type'=>'checkbox', 'title'=>My::t('app', 'Активен'), 'value'=>'1', 'checked'=>true, 'htmlOptions'=>['class'=>'checkbox'], 'htmlLabelOptions'=>['class'=>'icon-checkbox']],
	],
	'buttons'=>[
		'button'=>['type'=>'submit', 'value'=>'Добавить', 'htmlOptions'=>['class'=>'button', 'style'=>'margin: 0 auto']]
	]
]); ?>


	<?php echo $this->actionMessage; ?>
	
  <script>
function randomString() {
    var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
    var string_length = 25;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    document.getElementById("randomfield").value = randomstring;

}

</script>