<div class="subhead"><?php echo $this->_pageTitle; ?></div>
<div class="container-wrapper" style="padding-top: 0;">
    <?php if(!isset($offline)): ?>
        <ul class="ui-list">
            <li><?php echo My::t('app', 'The logo should be 16x16, in PNG, file size - no more than 128kb.'); ?></li>
            <li><?php echo My::t('app', 'Faction should be 3 level.'); ?> <h4 style="margin-top: 5px;"><?php echo My::t('app', 'Current faction:'); ?> <img style="margin-left: 3px; vertical-align: middle" src="guildicons/<?php echo (file_exists('guildicons/'.$factionId.'.png') ? $factionId : '0'); ?>.png" /> <?php echo $factionName; ?>, <?php echo My::t('app', 'Level'); ?> - <?php echo $factionLevel+1; ?></h4></li>
            <li><?php echo My::t('app', 'Price - {price}', array('{price}'=>($price > 0) ? $price : My::t('app', 'Free'))); ?></li>
        </ul>
        <?php echo CWidget::create('CFormView', array(
            'action'=>'icon/',
            'method'=>'post',
            'htmlOptions'=>array(
                'name'=>'service-form',
                'class'=>'light-form inline-label',
                'style'=>'float: none;',
                'onkeypress'=>'if (event.keyCode == 13) return false;',
                'enctype'=>'multipart/form-data'
            ),
            'fields'=>array(
                'act' =>array('type'=>'hidden', 'value'=>'send'),
                'icon'=>array('type'=>'file'),
            ),
            'buttons'=>array(
                'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Confirm operation'), 'htmlOptions'=>array('class'=>'button blue-gradient'.(isset($offline) ? ' disabled' : ''), 'onclick'=>'this.classList.add(\'disabled\');')),
            ),
            'return'=>true,
        )); ?>
    <?php endif; ?>
    <?php echo $actionMessage; ?>
</div>