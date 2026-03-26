<?php echo $actionMessage ?>
<div id="settings-content">
    <ul class="settings-list">
        <li class="subhead"><?php echo My::t('app', 'General Account Settings'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <?php /*<div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'account/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'displayName'=>array('type'=>'textbox', 'value'=>CAuth::getLoggedParam('loggedDisplayName'), 'htmlOptions'=>array('class'=>'field no-shadow', 'placeholder'=>My::t('app', 'Profile Name')))
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button2 small dark-blue right-float'))
                        ),
                        'return'=>true
                    )); ?>
                </div>*/ ?>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Profile Name'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo CAuth::getLoggedParam('loggedDisplayName'); ?> (выбранный персонаж)</div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Username'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo CAuth::getLoggedName(); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'User identifier'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo CAuth::getLoggedParam('loggedUID'); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Email'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo My::t('app', 'Primary email'); ?>: <?php echo CAuth::getLoggedEmail(); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'account/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'changePassword'),
                            'curPassword'=>array('type'=>'textbox', 'htmlOptions'=>array('class'=>'field no-shadow', 'placeholder'=>My::t('app', 'Current password'))),
                            'newPassword'=>array('type'=>'textbox', 'htmlOptions'=>array('class'=>'field no-shadow', 'placeholder'=>My::t('app', 'New password'))),
                            'passwordRetype'=>array('type'=>'textbox', 'htmlOptions'=>array('class'=>'field no-shadow', 'placeholder'=>My::t('app', 'Retype password'))),
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button2 small dark-blue right-float'))
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Password'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo My::t('app', 'Change current password'); ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Regional Settings'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'account/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'language'=>array('type'=>'dropdownlist', 'data'=>array('ru'=>My::t('i18n', 'languages.ru'), 'en'=>My::t('i18n', 'languages.en')), 'value'=>My::app()->getLanguage(), 'htmlOptions'=>array('class'=>'field no-shadow')),
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button2 small dark-blue right-float'))
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Language'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content" style="text-transform: capitalize;"><?php echo My::t('i18n', 'languages.'.My::app()->getLanguage()); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'account/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'timezone'=>array('type'=>'dropdownlist', 'data'=>CTimeZone::getTimeZones(), 'value'=>My::app()->getTimezone(), 'htmlOptions'=>array('class'=>'field no-shadow', 'style'=>'width: 235px;')),
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button2 small dark-blue right-float'))
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Time zone'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo My::app()->getTimezone(); ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Additional info'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Groups'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo My::t('app', 'roles.' . CAuth::getLoggedRole()); ?><?php echo (CAuth::getLoggedParam('isStaff') ? (', ' . My::t('app', 'Project staff')) : ''); ?></div>
            </div>
        </li>
    </ul>
</div>