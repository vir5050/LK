<div class="subhead"><?php echo My::t('app', 'Ingame chat'); ?></div>
<div class="container-wrapper">
    <div class="chat-message-list">
        <?php foreach((object)$this->chat as $message): ?>
            <div onmouseover="showTooltip(this, ge('msg-<?php echo $message['chat_id']; ?>').innerHTML, {target:this, tipJoint:'right', offset:[-5, -1]});" class="chat-message-block channel-<?php echo $message['channel']; ?>">
                <span class="message-channel channel-<?php echo $message['channel']; ?>"></span>
                <span class="message-author">
                    <?php if($message['channel'] == 3): ?>
                        <?php echo $message['dst_name']; ?>
                    <?php endif; ?>
                    <label><?php echo $message['src_name']; ?>:</label>
                </span>
                <span class="message-content"><?php echo Chat::formatter($message['msg'], $message['channel']); ?></span>
                <div class="no-display" id="msg-<?php echo $message['chat_id']; ?>">
                    <dl class="chat-message-info">
                        <dt><?php echo My::t('app', 'Character'); ?>:</dt>
                        <dd><?php echo $message['src']; ?></dd>
                    </dl>
                    <?php if($message['src_user'] != 0): ?>
                        <dl class="chat-message-info">
                            <dt><?php echo My::t('app', 'User identifier'); ?>:</dt>
                            <dd><?php echo $message['src_user']; ?></dd>
                        </dl>
                    <?php endif; ?>
                    <?php if($message['dst'] != 0): ?>
                        <dl class="chat-message-info">
                            <dt><?php echo My::t('app', 'Receiver'); ?>:</dt>
                            <dd><?php echo $message['dst']; ?></dd>
                        </dl>
                    <?php endif; ?>
                    <dl class="chat-message-info">
                        <dt><?php echo My::t('app', 'Time'); ?>:</dt>
                        <dd><?php echo CTime::makePretty($message['date']); ?></dd>
                    </dl>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>