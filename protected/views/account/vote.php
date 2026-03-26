<div class="subhead"><?php echo My::t('app', 'Vote'); ?></div>
<div class="container-wrapper" style="padding-top: 0;">
    <ul class="ui-list">
        <li><?php echo My::t('app', 'Funds in your MyWeb Wallet may be used for the purchase of any game items or using ingame services.'); ?></li>
        <li><?php echo My::t('app', 'Encouraging issued every 2 hours.'); ?></li>
		<a href="http://jd.mmotop.ru/servers/28204/" target="_blank">
	<img src="6.png" border="0" id="mmotopratingimg" alt="Рейтинг серверов mmotop">
	</a>
	<script type="text/javascript">document.write("<script src='http://js.mmotop.ru/rating_code.js?" + Math.round((((new Date()).getUTCDate() + (new Date()).getMonth() * 30) / 7)) + "_" + (new Date()).getFullYear() + "' type='text/javascript'><\/script>");</script>

    </ul>
</div>
<div class="subhead"><?php echo My::t('app', 'Bonuses'); ?></div>
<div class="container-wrapper" style="padding-top: 0;">
    <ul class="ui-list">
        <li>
            <?php echo My::t('app', 'Common vote'); ?> - <?php echo $this->model->coins_common; ?> <span id="common"></span>
            <?php if($this->model->encourage_item == 1 and $this->model->common_item_id !== ''): ?>
                <table style="margin-top: 5px;">
                    <tr>
                        <?php $store = Store::model()->findByPk($this->model->common_item_id); ?>
                        <td style="padding-left: 5px;"><a href="store/ajax/preview/<?php echo $store->store_id; ?>" onmouseover="showTooltip(this, 'Preview', {target:this.parentNode, tipJoint:'left', ajax:true, offset:[10, 0]});" style="display: block; background-image: url('uploads/Icons/<?php echo $store->item_id; ?>.png'); width: 32px; height: 32px;" onclick="return false;"></a></td>
                        <td style="padding-left: 5px;">
                            - <?php echo $store->name; ?> <strong>x<?php echo $this->model->common_item_count; ?></strong>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
        </li>
        <li>
            <?php echo My::t('app', 'Sms vote'); ?> - <?php echo $this->model->coins_sms; ?> <span id="sms"></span>
            <?php if($this->model->encourage_item == 1 and $this->model->sms_item_id !== ''): ?>
                <table style="margin-top: 5px;">
                    <tr>
                        <?php $store = Store::model()->findByPk($this->model->sms_item_id); ?>
                        <td style="padding-left: 5px;"><a href="store/ajax/preview/<?php echo $store->store_id; ?>" onmouseover="showTooltip(this, 'Preview', {target:this.parentNode, tipJoint:'left', ajax:true, offset:[10, 0]});" style="display: block; background-image: url('uploads/Icons/<?php echo $store->item_id; ?>.png'); width: 32px; height: 32px;" onclick="return false;"></a></td>
                        <td style="padding-left: 5px;">
                            - <?php echo $store->name; ?> <strong>x<?php echo $this->model->sms_item_count; ?></strong>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
        </li>
    </ul>
</div>
<script>
    declNum(ge('common'), [<?php echo My::t('app', 'coin_declinations'); ?>], <?php echo $this->model->coins_common; ?>);
    declNum(ge('sms'), [<?php echo My::t('app', 'coin_declinations'); ?>], <?php echo $this->model->coins_sms; ?>);
</script>