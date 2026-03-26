<div class="subhead" style="width: 100%;padding-bottom: 20px;font-family: Beaufort Bold;text-transform: uppercase;font-size: 25px;color: #562200;text-align: center;top: 10px;position: relative;"><?php echo My::t('app', 'ПОПОЛНИТЬ БАЛАНС'); ?></div>
<div class="container-wrapper" style="padding-top: 0;"><br />
<i class="fas fa-wallet" style="text-align: center;color: #e55454;display: block;font-size: 90px;"></i>
        <ul class="ui-list" style="margin: 0 30px 10px;">
		<li style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;margin-top: 15px;">У ВАС: <span style="color: #e67e22;"><?php echo User::model()->findByPk(CAuth::getLoggedId())->coins; ?></span> МОНЕТ</li>
            <li style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;margin-top: 15px;"><?php echo My::t('app', 'ЦЕНА ЗА 1 МОНЕТУ = 1 РУБЛЬ', array('{price}'=>($price > 0) ? $price : My::t('app', 'Free'))); ?></li>
        </ul>
    <?php echo CWidget::create('CFormView', array(
                'action'=>'account/addfunds/merchant/'.$this->merchant,
                'method'=>'post',
                'htmlOptions'=>array(
                    'name'=>'payment-form',
					'target'=>'_blank',
                    'style'=>'float: none;'
                ),
                'fields'=>array(
                    'act'=>array('type'=>'hidden', 'value'=>'send'),
                    'amount'=>array('type'=>'textbox', 'htmlOptions'=>array('class'=>'field2 transition', 'placeholder'=>My::t('app', 'Enter payment amount'), 'onkeyup'=>'calculateAmount('.CConfig::get('payment.value').', '.CConfig::get('payment.min_amount').', '.CConfig::get('payment.max_amount').', this, event);', 'autofocus'=>false, 'autocomplete'=>'off'))
                ),
            'buttons'=>array(
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'пополнить счет'), 'htmlOptions'=>array('style'=>'position: relative;text-align: center; width: 200px; height: 40px', 'class'=>'b-page-header__person2'.($repeat===null ? '' : ' disabled'), 'onclick'=>'this.form.submit();'), 'appendCode'=>($repeat===null ? '' : My::t('app', 'You can repeat this operation {time}', array('{time}'=>$repeat)))),
            ),
				
                'return'=>true
            )); ?>
    
    <?php if(CConfig::get('payment.bonus')): ?>
        <ul class="ui-list">
        <?php foreach(CConfig::get('payment.bonuses') as $bonus): ?>
            <li><?php echo My::t('app', 'Amount from'); ?> <strong><?php echo $bonus['step']; ?></strong>, <?php echo My::t('app', 'factor'); ?> - <strong><?php echo $bonus['factor']; ?></strong></li>
        <?php endforeach; ?>
        </ul>
        <p style="padding: 0 0 5px 10px;"><strong><?php echo My::t('app', 'Example'); ?>:</strong> <code style="font-size: 11px;font-family: Courier,sans-serif;color: rgb(13, 122, 245);">670*1.2=804</code></p>
		<div class="subhead">Есть возможность отправить пожертвование на прямую, тем самым не будет комиссии.</div>
		<div></div>
		<li>Qiwi: +79144736161</li>
		<li>Яндекс: 410015297476076</li>
		<li>Webmoney USD: Z912308938245</li>
		<li>Webmoney RUB: R419919268859</li>
		<div class="subhead">При переводе указывайте Логин на который зачислить монеты.</div>
    <?php endif; ?>

</div>