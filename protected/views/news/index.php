<div id="store-content">
            
	<div class="store-category-all">
 <div class="store-items-grid">           
			
	<?php if(!empty($posts)): ?>

        <?php foreach($posts as $post): ?>
						<div class="store-item-block" style="width: 48%;" >
                        <div class="item-info">
                        <div class="item-actions">
                            <div class="item-price"><a href='news/full/?id=<?php echo $post['post_id']; ?>' style="color: #ff9500;text-decoration: none;">
							<?php echo CHtml::decode($post['title']); ?></a>
							
							
							
							
<span style="font-size: 10px;position: absolute;text-align: right;left: 75%;">							
<i data-icon=""></i> <?php
                            $dt = new DateTime('@'.$post['post_date']);
                            $dt->setTimezone(new DateTimeZone(My::app()->getTimezone()));
                            echo '<span>'.$dt->format('j').'</span>'.My::t('i18n', 'monthNames.abbreviated.'.$dt->format('n')).' / '.$dt->format('Y');
                        ?>
</span>				
							
							
							
							</div>
                        </div>

                            <div class="item-icon" style="margin: 6px 10px 0 0;">
                                <img src="newsimg/<?php echo $post['img']; ?>" height="100px">
                            </div>

                        </div>
						<?php if(CAuth::isLoggedInAsAdmin()): ?>
                        <div class="item-edit" role="button" tabindex="0">
                            <i data-icon=""></i>
                            <div class="toggle-flyout light-ui" style="top: 25px; right: -10px; width: 120px;">
                                <ul class="user-navigation">
                                    <li><a onclick="return go(this, event);" href="post/?edit=<?php echo $post['post_id']; ?>" class="sub-link">Редактировать</a></li>
                                    <li><a href="javascript:;" onclick="Page.removePost('post/remove', <?php echo $post['post_id']; ?>);" class="sub-link">Удалить</a></li>
                                </ul>
                            </div>
                        </div>
						<?php endif; ?>
                                                <div class="item-details" style="height: 80px;">
<?php echo CHtml::decode($post['message']); ?>

                        </div>
                        <div class="item-actions" style="position: relative;text-align: right;padding-right: 15px;">
<a href='news/full/?id=<?php echo $post['post_id']; ?>' style="color: #ff9500;text-decoration: none;"> Подробно</a>
                        </div>
               </div> 
<?php endforeach; ?>

        <?php echo CWidget::create('CPagination', array(
            'htmlOptions'=>array('class'=>'pagination right'),
            'targetPath' => $targetPath,
            'currentPage' => $currentPage,
            'pageSize' => $pageSize,
            'totalRecords' => $totalRecords,
            'showTotal'=>false,
            'events'=>'onclick="return go(this, event);"'
        )); ?>
    <?php endif; ?>

    </div></div>
</div>
