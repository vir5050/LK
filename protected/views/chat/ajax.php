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