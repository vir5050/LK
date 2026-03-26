<div class="subhead"><?php echo $this->_pageTitle; ?></div>
<div class="container-wrapper">
    <?php if(!isset($offline)): ?>
        <p><?php echo My::t('app', 'The level boost system allow quickly and easily pump your character.'); ?></p>
        <ul class="ui-list" style="margin: 10px 30px;">
            <li><?php echo My::t('app', 'The selected character must be offline'); ?></li>
            <li><?php echo My::t('app', 'Max. level - {max}', array('{max}'=>$max)); ?></li>
            <li><?php echo My::t('app', 'Price for 1 level - {price}', array('{price}'=>($price > 0) ? $price : My::t('app', 'Free'))); ?></li>
        </ul>
        <?php echo CWidget::create('CFormView', array(
            'action'=>'level-boost/',
            'method'=>'post',
            'htmlOptions'=>array(
                'name'=>'service-form',
                'class'=>'light-form inline-label',
                'style'=>'float: none;',
                'onkeypress'=>'if (event.keyCode == 13) return false;'
            ),
            'fields'=>array(
                'act' =>array('type'=>'hidden', 'value'=>'send'),
                'count'=>array('type'=>'textbox', 'title'=>My::t('app', 'Enter count:'), 'htmlOptions'=>array('id'=>'level-count', 'class'=>'field small', 'autocomplete'=>'off')),
            ),
            'buttons'=>array(
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Confirm operation'), 'htmlOptions'=>array('class'=>'button blue-gradient disabled', 'onclick'=>'this.classList.add(\'disabled\');'), 'appendCode'=>'<input class="checkbox" type="checkbox" id="isOffline" onchange="if (this.checked == true) { this.parentNode.firstElementChild.classList.remove(\'disabled\'); } else { this.parentNode.firstElementChild.classList.add(\'disabled\'); }"><label class="icon-checkbox" for="isOffline" style="display: inline;">'.My::t('app', 'The character is offline').'</label>'),
            ),
            'events'=>array(
                'focus'=>array('field'=>$errorField),
                'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
            ),
            'return'=>true,
        )); ?>
    <?php endif; ?>
    <?php echo $actionMessage; ?>
</div>