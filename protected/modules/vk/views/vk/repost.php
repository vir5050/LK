<style>
    .repost-step {
        position: relative;
    }

    .repost-step span {
        display: block;
        position: relative;
        height: 35px;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        cursor: default;
    }

    .repost-step span:before {
        content: '';
        position: absolute;
        top: 50%; left: 0;
        width: 100%;
        height: 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .repost-step span:after {
        margin-left: -50px;
        content: attr(data-step);
        position: absolute;
        top: 0; left: 50%;
        background-color: rgb(255, 255, 255);
        width: 100px;
        height: 35px;
        line-height: 35px;
        font-size: 24px;
        text-transform: uppercase;
        color: rgba(0, 0, 0, 0.4);
        z-index: 2;
        text-align: center;
    }
</style>
<?php echo $this->actionMessage; ?>
<div class="container-wrapper" style="padding-top: 0;">
    <div class="repost-step">
        <span data-step="Шаг 1"></span>
        <?php if(isset($user) and $user !== null): ?>
            <div style="margin: 10px auto 5px; width: 50px; height: 50px;">
                <img style="border-radius: 50px;" src="<?php echo $user->photo_50; ?>" />
            </div>
            <div style="text-align: center;"><?php echo $user->first_name; ?> <?php echo $user->last_name; ?></div>
        <?php else: ?>
            <button onclick="top.location.href = '<?php echo $this->authorizeUrl; ?>';" style="margin: 10px auto; display: block;" class="button blue-gradient"><?php echo My::t('app', 'Привязать аккаунт'); ?></button>
        <?php endif; ?>
    </div>
    <div class="repost-step">
        <span data-step="Шаг 2"></span>
        <button onclick="top.location.href = '<?php echo $this->authorizeUrl; ?>';" style="margin: 10px auto; display: block;" class="button blue-gradient <?php if($user !== null) echo 'disabled'; ?>">Сделать репост</button>
    </div>
</div>