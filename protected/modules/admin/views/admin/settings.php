<div class="subhead">
    <a class="active" href="admin/settings" onclick="return go(this, event);"><?php echo My::t('app', 'Main Settings'); ?></a>
    <a href="admin/services" onclick="return go(this, event);"><?php echo My::t('app', 'Services Settings'); ?></a>
    <a href="admin/mmotop" onclick="return go(this, event);"><?php echo My::t('app', 'MMOTOP Settings'); ?></a>
</div>
<?php echo $actionMessage; ?>
<div id="settings-content">
    <ul class="settings-list">
        <li style="margin-top: 10px;">
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Template'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo My::app()->getRequest()->getBasePath(); ?>templates/<strong><?php echo $settings->template; ?></strong>/</div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'meta_title'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->meta_title, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'meta_title'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->meta_title; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'meta_description'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->meta_description, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'meta_description'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->meta_description; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'meta_keywords'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->meta_keywords, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'meta_keywords'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->meta_keywords; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'logo'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->logo, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Logo'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->logo; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'slogan'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->slogan, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Slogan'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->slogan; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'footer'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->footer, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Footer'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->footer; ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Registration Settings'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'cubigold_onstart'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$settings->cubigold_onstart, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Cubigold on start'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $simpleEnum[$settings->cubigold_onstart]; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'cubigold_count'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->cubigold_count, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Cubigold count'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->cubigold_count; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'registration_gift'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->registration_gift, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Registration gift'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content">
                    <?php
                        if($settings->registration_gift != ''){
                            $items = explode(',', str_replace(' ', '', $settings->registration_gift));
                            foreach($items as $item){
                                $store = Store::model()->findByPk($item);
                                if($store!==null){
                                    echo $store->store_id.' - '.$store->name.' x'.$store->count.' ('.My::t('app', 'Item id').': '.$store->item_id.')'.'<br />';
                                }else{
                                    echo $item.' - '.My::t('app', 'Invalid ID').'<br />';
                                }
                            }
                        }else{
                            echo My::t('app', 'No');
                        }
                    ?>
                </div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'lower_login'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$settings->lower_login, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Convert username to lowercase'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $simpleEnum[$settings->lower_login]; ?> <div style="margin-top: 5px; font-size: 10px;">(Ex.: LoGin => login)</div></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'lower_passwd'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$settings->lower_passwd, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Convert password to lowercase'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $simpleEnum[$settings->lower_passwd]; ?> <div style="margin-top: 5px; font-size: 10px;">(Ex.: PaSs => pass)</div></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Mail Settings'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'general_email'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->general_email, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Email'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo My::t('app', 'Primary email') ?>: <?php echo $settings->general_email; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'mailer'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$mailersList, 'value'=>$settings->mailer, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Mailer'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->mailer; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'email_secure'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$settings->email_secure, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Secure'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $simpleEnum[$settings->email_secure]; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'smtp_secure'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$smtp_secureList, 'value'=>$settings->smtp_secure, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'SMTP Secure'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $smtp_secureList[$settings->smtp_secure]; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'smtp_host'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->smtp_host, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'SMTP Host'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->smtp_host; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'smtp_port'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->smtp_port, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'SMTP Port'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->smtp_port; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'smtp_username'),
                            'value'=>array('type'=>'textbox', 'value'=>$settings->smtp_username, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'SMTP Username'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $settings->smtp_username; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/settings',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'smtp_password'),
                            'value'=>array('type'=>'textbox', 'value'=>'', 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'SMTP Password'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content">Encoded password</div>
            </div>
        </li>
    </ul>
</div>
<div class="container-wrapper">
    <div class="alert alert-info">
        <h4>URL оповещения для платежных систем:</h4><br />
        <pre>Free-kassa: <?php echo My::app()->getRequest()->getBaseUrl(); ?>payment/resultFk</pre>
        <pre>Paymentwall: <?php echo My::app()->getRequest()->getBaseUrl(); ?>payment/resultPw</pre>
        <pre>Unitpay: <?php echo My::app()->getRequest()->getBaseUrl(); ?>upbilling/index.php</pre>
    </div>
</div>