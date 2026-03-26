<div class="subhead"><?php echo My::t('app', 'User info'); ?></div>
<?php echo $actionMessage; ?>
<?php if(isset($user) and !empty($user)): ?>
<div id="settings-content">
    <ul class="settings-list">
        <li style="margin-top: 10px;">
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Username'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $user->username; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'display_name'),
                            'value'=>array('type'=>'textbox', 'value'=>$user->display_name, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Profile Name'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $user->display_name; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'user_id'),
                            'value'=>array('type'=>'textbox', 'value'=>$user->user_id, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'User identifier'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $user->user_id; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'email'),
                            'value'=>array('type'=>'textbox', 'value'=>$user->email, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <div class="settings-item-content"><?php echo $user->email; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'password'),
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Password'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $user->password; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'coins'),
                            'value'=>array('type'=>'textbox', 'value'=>$user->coins, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Wallet Balance'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $user->coins; ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Regional Settings'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'language_id'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$languageList, 'value'=>$user->language_id, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Language'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content" style="text-transform: capitalize;"><?php echo $languageList[$user->language_id]; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'timezone'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>CTimeZone::getTimeZones(), 'value'=>$user->timezone, 'htmlOptions'=>array('class'=>'field no-shadow', 'style'=>'width: 235px;')),
                        ),
                        'buttons'=>array(
                            'button'=>array('type'=>'button', 'value'=>My::t('core', 'Cancel'), 'htmlOptions'=>array('class'=>'cancel-link right-float', 'onmousedown'=>'Settings.cancelDetailed(this);')),
                            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Save changes'), 'htmlOptions'=>array('class'=>'button small dark-blue right-float'))
                        ),
                        'return'=>true
                    )); ?>
                </div>
                <h3 class="settings-list-label"><?php echo My::t('app', 'Time zone'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo $user->timezone; ?></div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Additional info'); ?></li>
        <li style="margin-top: 0;">
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'role'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$rolesList, 'value'=>$user->role, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Groups'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content" style="text-transform: capitalize;"><?php echo $rolesList[$user->role]; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'auth_ip'),
                            'value'=>array('type'=>'textbox', 'value'=>CIp::convertIpBinaryToString($user->auth_ip), 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Allow the authorization only from a specified IP address'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo CIp::convertIpBinaryToString($user->auth_ip); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Lastlogin to MyWeb'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo ($lastLogin !== null ? CIp::convertIpBinaryToString($lastLogin->ip_address) : ''); ?><br /><?php echo ($lastLogin !== null ? CTime::makePretty($lastLogin->request_date) : ''); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Lastlogin to game'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content"><?php echo (isset($userInfo['login_ip']) ? long2ip($userInfo['login_ip']) : ''); ?><br /><?php echo (isset($userInfo['login_time']) ? CTime::makePretty($userInfo['login_time']) : ''); ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <div class="settings-hidden-content">
                    <?php echo CWidget::create('CFormView', array(
                        'action'=>'admin/user-info/id/'.$user->id,
                        'method'=>'post',
                        'htmlOptions'=>array(
                            'name'=>'settings-form',
                            'class'=>'light-form',
                            'style'=>'text-align: right;'
                        ),
                        'fields'=>array(
                            'act'=>array('type'=>'hidden', 'value'=>'save'),
                            'key'=>array('type'=>'hidden', 'value'=>'is_banned'),
                            'value'=>array('type'=>'dropdownlist', 'data'=>$simpleEnum, 'value'=>$user->is_banned, 'htmlOptions'=>array('class'=>'field no-shadow'))
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
                <h3 class="settings-list-label"><?php echo My::t('app', 'Blocked in MyWeb'); ?></h3>
                <div class="settings-item-edit" onmousedown="Settings.detailed(this);"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content" style="text-transform: capitalize;"><?php echo $simpleEnum[$user->is_banned]; ?></div>
            </div>
        </li>
        <li>
            <div class="settings-list-content">
                <h3 class="settings-list-label"><?php echo My::t('app', 'Ban list'); ?></h3>
                <div class="settings-item-edit" style="display: none;"><?php echo My::t('app', 'Edit'); ?></div>
                <div class="settings-item-saved"><?php echo My::t('app', 'Changes saved'); ?></div>
                <div class="settings-item-content" style="width: 493px;">
                    <?php if(isset($userInfo['forbid']) and !empty($userInfo['forbid'])): ?>
                        <table class="primary-table">
                            <tr>
                                <th><?php echo My::t('app', 'Time'); ?></th>
                                <th><?php echo My::t('app', 'Issued'); ?></th>
                                <th><?php echo My::t('app', 'Reason'); ?></th>
                            </tr>
                        <?php foreach($userInfo['forbid'] as $forbid): ?>
                            <tr>
                                <td><?php echo CTime::convertSecondsToTime($forbid['time']); ?></td>
                                <td><?php echo CTime::makePretty($forbid['createtime'], 'abbreviated'); ?></td>
                                <td><?php echo $forbid['reason']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <li class="subhead"><?php echo My::t('app', 'Characters'); ?></li>
        <?php if(isset($userRoles) and !empty($userRoles)): ?>
            <?php foreach($userRoles as $role): ?>
                <li style="margin-top: 0;">
                    <div class="settings-list-content">
                        <h3 class="settings-list-label"><?php echo $role['id']; ?> - <?php echo $role['name']; ?></h3>
                        <div class="settings-item-edit" onclick="if (confirm('<?php echo My::t('app', 'Confirm operation'); ?>')) CharmBar.request('POST', 'admin/ajax', {act:'del_char', id:<?php echo $role['id']; ?>}, this.nextElementSibling);"><?php echo My::t('app', 'Delete'); ?></div>
                        <div class="settings-item-content"></div>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
<?php else: ?>
<div class="container-wrapper">
    <?php echo CWidget::create('CFormView', array(
        'action'=>'admin/user-info',
        'method'=>'get',
        'htmlOptions'=>array(
            'name'=>'settings-form',
            'class'=>'light-form',
            'style'=>'float: none;'
        ),
        'fields'=>array(
            'id'=>array('type'=>'textbox', 'title'=>My::t('app', 'ID or Username'), 'htmlOptions'=>array('class'=>'field no-shadow'))
        ),
        'buttons'=>array(
            'submit'=>array('type'=>'submit', 'value'=>My::t('app', 'Send'), 'htmlOptions'=>array('class'=>'button blue-gradient right-float'))
        ),
        'events'=>array(
            'scroll'=>'Page.scrollTo(window.pageYOffset, 265);'
        ),
        'return'=>true
    )); ?>
</div>
<div class="subhead"><?php echo My::t('app', 'List of users'); ?></div>
<div class="container-wrapper">
    <?php if(!empty($users)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th style="width: 100px;"><?php echo My::t('app', 'Account ID'); ?></th>
                <th><?php echo My::t('app', 'Username'); ?></th>
                <th><?php echo My::t('core', 'Action'); ?></th>
            </tr>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td style="width: 50px;"><a href="admin/user-info/id/<?php echo $user['id']; ?>"><?php echo My::t('app', 'Edit'); ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords,
            'events'=>'onclick="return go(this, event);"'
        )); ?>
    <?php endif; ?>
</div>
<?php endif; ?>