<div class="subhead">
	<div style="font-weight: normal; float: right;" id="update-interval">Обновление чата через 60 сек...</div>
    <?php echo My::t('app', 'Ировой чат в реальном времени'); ?>
</div>
<div class="container-wrapper">
    <div class="chat-message-list">
        <?php if(isset($chat) and !empty($chat)): ?>
            <?php foreach($chat as $message): ?>
                <div class="chat-message-block channel-<?php echo $message['channel']; ?>">
                    <span class="channel channel-<?php echo $message['channel']; ?>"></span>
                    <span class="message-author">
                        <?php if($message['channel'] == 3): ?>
                            <?php echo $message['dst_name']; ?>
                        <?php endif; ?>
                        <label><?php echo $message['src_name']; ?><?php if($message['channel'] == 4): ?> шепчет с <?php echo $message['dst_name']; ?><?php endif; ?>:</label>
                    </span>
                    <span class="message-content"><?php echo Chat::formatter($message['msg'], $message['channel']); ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript">
    var list = qs('.chat-message-list'), interval = 60;

    list.scrollTop = list.scrollHeight;
    var chatint = setInterval(function() {
        ajax.send('GET', 'chat/ajax', {}, null, function(response) {
            list.innerHTML = response;
            list.scrollTop = list.scrollHeight;
        });
    }, 60000);
	
    setInterval(function() {
        if (interval >= 0) {
            ge('update-interval').innerHTML = 'Обновление чата через ' + interval.toString() + ' сек...';
			interval--;
        } else {
            interval = 60;
        }
    }, 1000);
</script>