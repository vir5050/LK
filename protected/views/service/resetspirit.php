<div class="subhead"><?php echo $this->_pageTitle; ?></div>
<div class="container-wrapper">
    <?php if(!isset($offline)): ?>
        <p><?php echo My::t('app', 'Reset spirit if it is below zero.'); ?></p>
        <ul class="ui-list" style="margin: 10px 30px;">
            <li><?php echo My::t('app', 'The selected character must be offline'); ?></li>
            <li><?php echo My::t('app', 'Price - {price}', array('{price}'=>($price > 0) ? $price : My::t('app', 'Free'))); ?></li>
        </ul>
        <?php echo CWidget::create('CFormView', array(
            'action'=>'reset-spirit/',
            'method'=>'post',
            'htmlOptions'=>array(
                'name'=>'service-form',
                'class'=>'light-form inline-label',
                'style'=>'float: none;'
            ),
            'fields'=>array(
                'act' =>array('type'=>'hidden', 'value'=>'send'),
            ),
            'buttons'=>array(
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Confirm operation'), 'htmlOptions'=>array('class'=>'button blue-gradient disabled', 'onclick'=>'this.classList.add(\'disabled\');'), 'appendCode'=>'<input class="checkbox" type="checkbox" id="isOffline" onchange="if (this.checked == true) { this.parentNode.firstElementChild.classList.remove(\'disabled\'); } else { this.parentNode.firstElementChild.classList.add(\'disabled\'); }"><label class="icon-checkbox" for="isOffline" style="display: inline;">'.My::t('app', 'The character is offline').'</label>'),
            ),
            'events'=>array(
                'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
            ),
            'return'=>true,
        )); ?>
    <?php endif; ?>
    <?php echo $actionMessage; ?>
</div>