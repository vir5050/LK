<div class="subhead"><?php echo My::t('app', 'Friend Invite System') ?></div>
<div class="container-wrapper" style="padding-bottom: 5px;">
    <p><?php echo My::t('app', 'Invite your friends to the game - with your help they will receive great gifts and you\'ll earn valuable bonuses! To do this, just give them a link or inform invitational invitation code.'); ?></p>
    <div style="margin-top: 15px;">
        <?php echo My::t('app', 'Your Referral Code') ?>:
        <div class="field-group" style="margin-top: 5px;">
            </i><input type="text" class="field no-hover" value="<?php echo $referralId ?>" style="width: 100%; cursor: pointer; text-align: center; font-size: 15px; height: 30px;" onmousedown="this.select();" readonly />
        </div>
    </div>
    <div style="margin-top: 5px;">
        <?php echo My::t('app', 'Your Referral URL') ?>:
        <div class="field-group" style="margin-top: 5px;">
            </i><input type="text" class="field no-hover" value="<?php echo $referralUrl ?>" style="width: 100%; cursor: pointer; text-align: center; font-size: 15px; height: 30px;" onmousedown="this.select();" readonly />
        </div>
    </div>
    <div style="margin-top: 20px;">
        <p style="margin-bottom: 5px;"><span class="raquo">&raquo;</span> <strong><?php echo My::t('app', 'Important:'); ?></strong> <?php echo My::t('app', 'invitation code can be activated only when creating a new account.'); ?></p>
        <p><?php echo My::t('app', 'Using your invitation code when creating a new account, user will forever be your follower. The numbers must be entered in the appropriate box under «REFERRAL PROGRAM».'); ?></p>
        <p style="margin-top: 5px;"><span class="raquo">&raquo;</span> <strong><?php echo My::t('app', 'Important:'); ?></strong> <?php echo My::t('app', 'all requirements are specified for follower.'); ?></p>
    </div>
</div>
<div class="subhead"><?php echo My::t('app', 'Description Invite System') ?></div>
<div class="container-wrapper">
    <?php if(CConfig::get('referral.ingameitems.enable')): ?>
        <p><?php echo My::t('app', 'Every follower receives a set of useful items that will help him in the beginning of the game:'); ?></p>
        <table style="margin-top: 5px;">
            <?php foreach(CConfig::get('referral.ingameitems.follower') as $item): ?>
                <tr>
                    <?php $store = Store::model()->findByPk($item['id']); ?>
                    <td style="padding-left: 5px;"><a href="store/ajax/preview/<?php echo $store->store_id; ?>" onmouseover="showTooltip(this, 'Preview', {target:this.parentNode, tipJoint:'left', ajax:true, offset:[10, 0]});" style="display: block; background-image: url('uploads/Icons/<?php echo $store->item_id; ?>.png'); width: 36px; height: 36px;" onclick="return false;"></a></td>
                    <td style="padding-left: 5px;">
                        - <?php echo $store->name; ?> <strong>x<?php echo $item['count']; ?></strong>.
                        <?php if(isset($item['requirements'])): ?>
                            <?php if(isset($item['requirements']['level'])): ?>
                                <span class="raquo">&raquo;</span><span class="raquo-desc"><?php echo My::t('app', 'Required level - {level}.', array('{level}'=>$item['requirements']['level'])); ?></span>
                            <?php endif; ?>
                            <?php if(isset($item['requirements']['reborn'])): ?>
                                <span class="raquo">&raquo;</span><span class="raquo-desc"><?php echo My::t('app', 'Требуемый уровень после перерождения - {level}.', array('{level}'=>$item['requirements']['reborn'])); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p style="margin-top: 10px;"><?php echo My::t('app', 'You get:'); ?></p>
        <table style="margin-top: 5px;">
            <?php foreach(CConfig::get('referral.ingameitems.referral') as $item): ?>
                <tr>
                    <?php $store = Store::model()->findByPk($item['id']); ?>
                    <td style="padding-left: 5px;"><a href="store/ajax/preview/<?php echo $store->store_id; ?>" onmouseover="showTooltip(this, 'Preview', {target:this.parentNode, tipJoint:'left', ajax:true, offset:[10, 0]});" style="display: block; background-image: url('uploads/Icons/<?php echo $store->item_id; ?>.png'); width: 36px; height: 36px;" onclick="return false;"></a></td>
                    <td style="padding-left: 5px;">
                        - <?php echo $store->name; ?> <strong>x<?php echo $item['count']; ?></strong>.
                        <?php if(isset($item['requirements'])): ?>
                            <?php if(isset($item['requirements']['level'])): ?>
                                <span class="raquo">&raquo;</span><span class="raquo-desc"><?php echo My::t('app', 'Required level - {level}.', array('{level}'=>$item['requirements']['level'])); ?></span>
                            <?php endif; ?>
                            <?php if(isset($item['requirements']['reborn'])): ?>
                                <span class="raquo">&raquo;</span><span class="raquo-desc"><?php echo My::t('app', 'Требуемый уровень после перерождения - {level}.', array('{level}'=>$item['requirements']['reborn'])); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
<div class="subhead"><?php echo My::t('app', 'Your followers') ?></div>
<div class="container-wrapper">
    <?php if(isset($referrals) and !empty($referrals)): ?>
        <table class="primary-table" style="width: 100%;">
            <tr>
                <th>#</th>
                <th><?php echo My::t('app', 'Ник персонажа'); ?></th>
                <th><?php echo My::t('app', 'Available profit'); ?></th>
                <th><?php echo My::t('app', 'Total profit'); ?></th>
                <th><?php echo My::t('app', 'Joined'); ?></th>
                <th><?php echo My::t('core', 'Action'); ?></th>
            </tr>
            <?php foreach($referrals as $k=>$v): ?>
                <tr>
                    <td><?php echo ($k+1); ?></td>
                    <td><?php
						$follower = User::model()->findByPk($v['follower_id']);
						if ($follower->display_name !== '' AND $follower->display_name !== $follower->username) {
							echo $follower->display_name;
						} else {
							echo 'Персонаж не создан';
						}
						
					?></td>
                    <td><?php echo $v['follower_current_profit']; ?></td>
                    <td><?php echo $v['follower_total_profit']; ?></td>
                    <td><?php echo CTime::makePretty($v['referral_joined']); ?></td>
                    <td>
                        <?php if($v['follower_current_profit'] > 0): ?>
                            <a href="javascript:void(0);" onclick="getProfit(<?php echo $v['follower_id']; ?>, this);" class="primary-link"><?php echo My::t('app', 'Take profit'); ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>