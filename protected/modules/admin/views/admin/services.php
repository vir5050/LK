<div class="subhead">
    <a href="admin/settings" onclick="return go(this, event);"><?php echo My::t('app', 'Main Settings'); ?></a>
    <a class="active" href="admin/services" onclick="return go(this, event);"><?php echo My::t('app', 'Services Settings'); ?></a>
    <a href="admin/mmotop" onclick="return go(this, event);"><?php echo My::t('app', 'MMOTOP Settings'); ?></a>
</div>
<?php echo $actionMessage; ?>
<style>.field-group > label { font-size: 13px; }</style>
<div id="settings-content">
    <ul class="settings-list">
        <li style="margin-top: 10px;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'levelboost'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[0]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[0]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'max'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. level'), 'value'=>$services[0]['max'], 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Level boost'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'clearstorehousepasswd'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[1]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[1]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Reset storehouse password'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'changecultivation'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[2]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[2]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Change cultivation'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'teleport'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[3]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[3]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'value'=>array('type'=>'textbox', 'value'=>$services[3]['value'], 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Teleport to the safe place'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'resetspirit'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[4]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[4]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Reset spirit'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'resetexperience'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[5]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[5]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Reset experience'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'renamecharacter'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[6]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[6]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Rename character'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'chatbroadcast'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[7]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[7]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'max'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. length'), 'value'=>$services[7]['max'], 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Chat broadcast'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'exchangegold'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[13]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[13]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'max'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. count'), 'value'=>$services[13]['max'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Exchange of MyWeb coins for cubigold'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'guildicon'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[15]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[15]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Submitting a faction logo'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'skills'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[14]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'hidden', 'value'=>'0'),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Learning skills'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Reforge items'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'addcells'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[8]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[8]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'max'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. cells'), 'value'=>$services[8]['max'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Add cells'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'attackrange'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[9]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[9]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'max'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. range'), 'value'=>$services[9]['max'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Add attack range'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'attackspeed'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[10]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[10]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'max'=>array('type'=>'textbox', 'title'=>My::t('app', 'Max. speed'), 'value'=>$services[10]['max'], 'htmlOptions'=>array('class'=>'field no-shadow'), 'appendCode'=>'<div style="font-size: 12px;">20 / n = attack speed (ex.: 20 / 4 = 5.00)</div>'),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Add attack speed'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'distancefragility'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[11]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[11]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Delete distance fragility'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/services',
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form inline-label',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'service'=>array('type'=>'hidden', 'value'=>'itemcreator'),
                            'enable'=>array('type'=>'dropdownlist', 'title'=>My::t('app', 'Can be used'), 'data'=>$simpleEnum, 'value'=>$services[12]['enable'], 'htmlOptions'=>array('class'=>'field no-shadow')),
                            'price'=>array('type'=>'textbox', 'title'=>My::t('app', 'Price'), 'value'=>$services[12]['price'], 'htmlOptions'=>array('class'=>'field no-shadow')),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Change item creator'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"></div>
            </div>
        </li>
    </ul>
</div>