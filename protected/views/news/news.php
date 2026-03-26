
    <?php if(!empty($posts)): ?>

        <?php foreach($posts as $post): ?>


<?php if(CAuth::isLoggedInAsAdmin()): ?>
<!--<div class="desc"><p>
                        <a  href="post/?edit=<?php echo $post['post_id']; ?>"><i data-icon="&#xe046;"></i></a>
                        <a  href="javascript:;" onclick="Page.removePost('post/remove', <?php echo $post['post_id']; ?>);" ><i data-icon="&#xe005;"></i>
						</a></p>
		
		</div>-->

                    <?php endif; ?>
<div class="news">
	<a href='news/full/?id=<?php echo $post['post_id']; ?>'>
		<div class="img"><img src="newsimg/<?php echo $post['img']; ?>" alt=""></div>
		<?php
            $dt = new DateTime('@'.$post['post_date']);
            $dt->setTimezone(new DateTimeZone(My::app()->getTimezone()));
            echo '<span class="date"><div><span class="day">'.$dt->format('j').'</span><span class="month">'.My::t('i18n', 'monthNames.abbreviated.'.$dt->format('n')).' </span></div></span>'.$dt->format('Y');
        ?>
		<div class="title"><?php echo CHtml::decode($post['title']); ?></div>
		<div class="desc"><p><?php echo CHtml::decode($post['message']); ?></p>
		
		</div>

	</a>
                    
</div>
        <?php endforeach; ?>

		
<a href="news/" style="text-align: right;font-family: Beaufort;color: #ff9500;font-size: 16px;display: block;text-decoration-line: revert;text-decoration-color: #ff9500;"
>Все новости</a>

    <?php endif; ?>
