<div class="subhead" style="width: 100%;padding-bottom: 20px;font-family: Beaufort Bold;text-transform: uppercase;font-size: 25px;color: #562200;text-align: center;top: 10px;position: relative;"><?php echo My::t('app', 'ПЕРЕВОД МОНЕТ В ИГРУ'); ?></div>
<div class="container-wrapper">
    <?php if(!isset($offline)): ?>
	<i class="fab fa-envira" style="text-align: center;color: #5fe554;display: block;font-size: 90px;"></i>

        <ul class="ui-list" style="margin: 0 30px 10px;">
            <li style="width: 100%;text-align: center;font-family: Beaufort;color: #533724;font-size: 16px;margin-top: 15px;"><?php echo My::t('app', 'ЦЕНА ЗА 1 ЛИСТ = {price} РУБЛЬ', array('{price}'=>($price > 0) ? $price : My::t('app', 'Free'))); ?></li>
        </ul>
        <?php echo CWidget::create('CFormView', array(
            'action'=>'exchange/cubigold',
            'method'=>'post',
            'htmlOptions'=>array(
                'style'=>'float: none;',
                'onkeypress'=>'if (event.keyCode == 13) return false;'
            ),
            'fields'=>array(
                'act' =>array('type'=>'hidden', 'value'=>'send'),
                'count'=>array('type'=>'textbox', 'htmlOptions'=>array('id'=>'gold-count', 'class'=>'field2 transition', 'placeholder'=>'Введите количество', 'autocomplete'=>'off')),
            ),
            'buttons'=>array(
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'ОТПРАВИТЬ'), 'htmlOptions'=>array('style'=>'position: relative;text-align: center; width: 200px; height: 40px', 'class'=>'b-page-header__person2'.($repeat===null ? '' : ' disabled'), 'onclick'=>'this.classList.add(\'disabled\');'), 'appendCode'=>($repeat===null ? '' : My::t('app', 'You can repeat this operation {time}', array('{time}'=>$repeat)))),
            ),
            'events'=>array(
                'focus'=>array('field'=>$errorField)
            ),
            'return'=>true,
        )); ?>
    <?php endif; ?>
    <?php echo $this->actionMessage; ?>
</div>
