<div class="subhead">
    <a href="admin/settings" onclick="return go(this, event);"><?php echo My::t('app', 'Main Settings'); ?></a>
    <a href="admin/services" onclick="return go(this, event);"><?php echo My::t('app', 'Services Settings'); ?></a>
    <a class="active" href="admin/mmotop" onclick="return go(this, event);"><?php echo My::t('app', 'MMOTOP Settings'); ?></a>
</div>
<?php echo $actionMessage; ?>
<div id="settings-content">
    <ul class="settings-list">
        <li style="margin-top: 10px;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'coins_common'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->coins_common, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Common vote'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->coins_common; ?></div>
            </div>
        </li>
		<li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'coins_sms'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->coins_sms, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Sms vote'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->coins_sms; ?></div>
            </div>
        </li>
		<li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'logs'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->logs, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Vote Logs'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->logs; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'reference_date'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->reference_date, 'htmlOptions'=>array('class'=>'field no-shadow', 'placeholder'=>'DD.MM.YYYY'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Reference date'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->reference_date; ?></div>
            </div>
        </li>
		<li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'catch_cheaters'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$settings->catch_cheaters, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Catch cheaters'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $simpleEnum[$settings->catch_cheaters]; ?></div>
            </div>
        </li>
		<li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'encourage_item'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$settings->encourage_item, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Encourage item'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $simpleEnum[$settings->encourage_item]; ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Common vote'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'common_item_id'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->common_item_id, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Item from store'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content">
                    <?php
                        $store = Store::model()->findByPk($settings->common_item_id);
                        if($store!==null){
                            echo $store->store_id.' - '.$store->name.' ('.My::t('app', 'Item id').': '.$store->item_id.')';
                        }else{
                            echo My::t('app', 'Invalid ID');
                        }
                    ?>
                </div>
            </div>
        </li>
		<li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'common_item_count'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->common_item_count, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Count'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->common_item_count; ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Sms vote'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'sms_item_id'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->sms_item_id, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Item from store'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content">
                    <?php
                        $store = Store::model()->findByPk($settings->sms_item_id);
                        if($store !== null){
                            echo $store->store_id.' - '.$store->name.' ('.My::t('app', 'Item id').': '.$store->item_id.')';
                        }else{
                            echo My::t('app', 'Invalid ID');
                        }
                    ?>
                </div>
            </div>
        </li>
		<li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/mmotop',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'sms_item_count'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->sms_item_count, 'htmlOptions'=>array('class'=>'field no-shadow'))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'events'=>array(
                            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Count'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->sms_item_count; ?></div>
            </div>
        </li>
    </ul>
</div>
<div class="alert alert-info">
    <pre>crontab -u root -e<br />*/30 * * * * wget -O /dev/null -q <?php echo My::app()->getRequest()->getBaseUrl(); ?>voterating/mmotop?key=<?php echo CConfig::get('installationKey'); ?></pre>
</div>