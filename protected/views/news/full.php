    <?PHP
     

$MySQL_HOST = CConfig::get('news_host');
$MySQL_USER = CConfig::get('news_user');			
$MySQL_USER_PASS = CConfig::get('news_pass');
$MySQL_DB = CConfig::get('news_db');
$MySQL_Connect = MySQL_Connect($MySQL_HOST, $MySQL_USER, $MySQL_USER_PASS) or die ("ќшибка соединени¤ с MySQL.");
MySQL_Select_Db($MySQL_DB, $MySQL_Connect) or die ("Ѕазы {$MySQL_DB} не существует.");
setlocale(LC_ALL, 'ru_RU.utf-8');
mysql_query("SET character_set_results='utf8'");
mysql_query("SET NAMES 'utf8'");
if ($_GET['id']) {  
 $id = (int)$_GET['id'];
        $result = mysql_query("SELECT * FROM `mw_post`  WHERE `post_id` = '$id' LIMIT 1");
        $row = mysql_fetch_assoc($result);
                $message=$row['message'];
				$title=$row['title'];
				$post_id=$row['post_id'];
$dt = new DateTime('@'.$row['post_date']);
$dt->setTimezone(new DateTimeZone(My::app()->getTimezone()));

}
    ?>
<div class="subhead" style="font-size: 20px;"><?php echo "$title"; ?>
 <span style="font-size: 14px;font-family: 'Raleway', sans-serif;color: #dd461a;"> <?php echo '<span>'.$dt->format('j').'</span>'.My::t('i18n', 'monthNames.abbreviated.'.$dt->format('n')).' / '.$dt->format('Y'); ?></span>
</div>
<div class="container-wrapper">

	



      <div class="desc2"><p><?php echo CHtml::decode($message); ?></p>
		
		</div>                  
						












                    <?php if(CAuth::isLoggedInAsAdmin()): ?>
                    <div class="post-control">
                        <a class="edit" href="post/?edit=<?php echo "$post_id"; ?>" onmouseover="showTooltip(this, '<?php echo My::t('app', 'Edit'); ?>', {target:this.parentNode, tipJoint:'right', offset:[-10, 0]});"><i data-icon="&#xe046;"></i></a>
                        <a class="delete" href="javascript:;" onclick="Page.removePost('post/remove', <?php echo "$post_id"; ?>);" onmouseover="showTooltip(this, '<?php echo My::t('app', 'Delete'); ?>', {target:this.parentNode, tipJoint:'right', offset:[-10, 0]});"><i data-icon="&#xe005;"></i></a>
                    </div>
                    <?php endif; ?>

</div>