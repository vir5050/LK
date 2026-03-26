<!DOCTYPE html>
<html lang="ru">
<head>
	<title><?php echo CHtml::encode($this->_pageTitle); ?></title>
	<link rel="shortcut icon" href="favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="Description" content="<?php echo CHtml::encode($this->_pageDescription); ?>">
	<meta name="Keywords" content="<?php echo CHtml::encode($this->_pageKeywords); ?>">
	<base href="<?php echo My::app()->getRequest()->getBaseUrl(); ?>" />
	<?php echo CHtml::cssFile('templates/default/css/style.css'); ?>
	<?php echo CHtml::cssFile('templates/default/css/engine.css'); ?>
	<?php echo CHtml::cssFile('templates/default/css/select.css'); ?>
	<?php echo CHtml::cssFile('templates/default/css/media.css'); ?>
	<link href="https://fonts.googleapis.com/css?family=Alice|Raleway:300,400,500,600,700,800,900|Russo+One&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <?php echo CHtml::cssFile('css/reset.css'); ?>
    <?php echo CHtml::cssFile('css/IcoMoon.css'); ?>
    <?php echo CHtml::cssFile('css/Opentip.css'); ?>
<?php echo CHtml::cssFile('templates/default/css/styles.css?v=2'); ?>
    <?php echo CHtml::scriptFile('js/vendors/Opentip.js'); ?>
    <?php echo CHtml::scriptFile('templates/default/js/page.js'); ?>
    <?php echo CHtml::scriptFile('templates/default/js/jquery-1.11.3.min.js'); ?>
	<?php echo CHtml::scriptFile('templates/default/js/scripts.js'); ?>
	<?php echo CHtml::scriptFile('templates/default/js/select.js'); ?>
	<?php echo CHtml::scriptFile('templates/default/js/circle-progress.js'); ?>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>
    <script type="text/javascript">
        window.onscroll = function(event) {
            var th = qs('.top-header'), doc = document.documentElement,
                top = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);

            if (top >= 260) {
                th.classList.add('fixed');
            } else {
                th.classList.remove('fixed');
            }
        };
    </script>
</head>
<body>
<div class="nav">
	<div class="nav-inner">
		<ul style="width: 600px;">
		
		<a href="/" class="logo2"><img src="templates/default/images/logo2.png" alt=""></a>		
		
		
		
			<li><a href="/">Главная</a></li>
			<li><a href="menu/node/id/1">Скачать клиент</a></li>
			<li><a href="/index.php?f=about">О сервере</a></li>
			<li><a href="/forum">Форум</a></li>
			<li><a href="/forum">Голосовать</a></li>
		</ul>
		
		
		<div class="lang">
  <ul class="user-menu" style="position: relative; top: -12px;">
<?php if(CAuth::isLoggedIn()): ?>
<?php else: ?>
  <li class="left-float white _h"><a href="user/login"  style="position: relative;top: -7px;font-size: 17px;color: #000;opacity: 1.0;left: -40px;width: 50px;">Вход</a></li>
  <?php endif ?>
        <?php if(CAuth::isLoggedIn()): ?>
            <?php if(CAuth::getLoggedParam('selectedRoleId')): ?>
                <li class="left-float white _h" tabindex="0" role="button">
                    <div class="inner-link"><span class="role-avatar role-cls s25 cls-<?php echo CAuth::getLoggedParam('selectedRoleCls'); ?> left-float" style="margin-top: 4px;"></span><label><?php echo CAuth::getLoggedParam('selectedRoleName'); ?></label></div>
                    <div class="bottom-line"></div>
                    <div class="toggle-flyout left no-tail" style="top: 38px; width: 320px;">
                        <table class="role-info">
                            <tr>
                                <td colspan="2" style="text-align: center;"><a href="/level-boost/" onclick="return go(this, event);"><?php echo My::t('app', 'Level boost'); ?></a></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;"><a href="exchange/cubigold" onclick="return go(this, event);"><?php echo My::t('app', 'Exchange of MyWeb coins for cubigold'); ?></a></td>
                            </tr>
                        </table>
                    </div>
                </li>
            <?php endif; ?>


			<li class="left-float white _h"><a href="user/logout" style="position: relative;top: -7px;font-size: 17px;color: #000;opacity: 1.0;left: -40px;width: 50px;">Выход</a></li>

			<li class="left-float white _h" tabindex="0" role="button" onfocus="CharmBar.roles(this);" selected-role="<?php echo CAuth::getLoggedParam('selectedRoleId'); ?>">
                <div class="inner-link"><?php echo My::t('app', 'Characters'); ?></div>
                <div class="bottom-line"></div>
                <div class="toggle-flyout right no-tail" style="top: 38px; width: 200px;">
                    <table class="user-roles"></table>
                </div>
            </li>
            <li class="left-float">
                <div class="icons-container">
                    <?php $noticeCount = (int)Notice::model()->countByAttributes(array('account_id'=>CAuth::getLoggedId())); ?>
                    <div class="left-float _h" tabindex="0" role="button" onfocus="CharmBar.notifications(<?php echo $noticeCount; ?>, this);">
                        <div class="jewels-count" data-count="<?php echo $noticeCount; ?>"></div>
                        <i data-icon="&#xe37e;"></i>
                        <div class="toggle-flyout" style="width: 330px;">
                            <div class="toggle-flyout-header">
                                <h3><?php echo My::t('app', 'Notifications'); ?></h3>
                            </div>
                            <ul class="toggle-flyout-content"></ul>
                        </div>
                    </div>

                </div>
				
				<div class="icons-container">
                    <?php if(CAuth::isLoggedInAsAdmin()): ?>
                        <div class="left-float" onclick="CharmBar.panelShow();">
                            <i data-icon="&#xe0aa;" style="position: relative;top: -34px; left: 40px;"></i>
                        </div>
                    <?php endif; ?>

                </div>
                </div>
            </li>
			


        <?php endif ?>
    </ul>


		</div>
	</div>
</div>















<div id="general">
	<div class="wrapper">

		<div class="inner screen-1"<?php if($_SERVER['REQUEST_URI'] == '/') { ?>style="height:320px;"<?php } else { ?> style="height:220px;"<?php } ?>>
			<a href="/" class="logo"></a>
			<div class="text">
				<div class="text-1">Фантастическиe<br> сервера<br><span>Fufarion,Seven Sings, interlude</span></div>
				<div class="text-2">
					Еще больше крутых обновлений и игровых систем<br><span>Полу Пвп сервера на любой вкус</span> - <span>пора захватывать Аден</span><br>
				</div>
			</div>
			<?php if(CConfig::get('components.sidebar.enable')): ?>
            <?php echo Sidebar::init()->serverStatus(true); ?>
			<?php endif; ?>
		</div>
<?php if(CAuth::isLoggedIn()): ?>
<?php else: ?>
		<div class="inner screen-2">
			<div class="links">
				<a href="menu/node/id/1"><span>СКАЧАТЬ ФАЙЛЫ</span></a>
				<a href="user/join"><span>РЕГИСТРАЦИЯ</span></a>
			</div>
		</div>
		<?php endif ?>
<?php if($_SERVER['REQUEST_URI'] == '/') { ?>
		<div class="inner screen-3">
    <div id="left-content-area">
        <?php echo My::app()->view->getContent(); ?>
    </div>
		</div>
		<div class="inner screen-4">
			<div class="side-left side-content" style="width: 950px;height: 620px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border: none;">
				<div class="title"><span>ЛУЧШИЕ ИГРОКИ</span> СЕРВЕРА</div>
				 <div class="desc">Топ 5 лучших игроков на нашем сервере</div>
				
				
				
				

				
				
				
				
<!--Модуль PvP Top -->
<table class="table-top">
	<tr>
		<th>&nbsp;</th>
		<th>Игрок</th>
		<th>PvP</th>
		<th>/</th>
		<th>PK</th>
	</tr>
	

<tr>
	<td>1.</td>
	<td>testpvp</td>
	<td>0</td>
	<td>/</td>
	<td>0</td>
</tr>

</table>


			</div>
			<div class="side-right side-content" style="height: 620px;width: 300px; border: none;">
				<div class="title"><span>МЫ</span> ВКОНТАКТЕ</div>
				<div class="desc">Общайтесь с нами в социальной сети!</div>
				
<!-- Модуль Темы с Форума -->
<div id="lastpost">


<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 4, width: "300", height: "530"}, 81128111);
</script>
</div>



			</div>
		</div>
		

<?php } else { ?>
		<div class="inner screen-3 screen-4">
<div >
<div class="side-left side-content2" style="border-radius: 8px;width: 78%;">
<div id="lastpost2" style="width: 90%;">
<div id="left-content-area">
	<?php echo My::app()->view->getContent(); ?>
</div>
	</br ></br >
</div>
</div>

<div class="side-right side-content2" style="border-radius: 8px;width: 20%;">
<div id="lastpost2">
<?php echo CAuth::getLoggedParam('loggedDisplayName'); ?>












<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>
@import url('https://fonts.googleapis.com/css?family=Roboto');
.widget {
  display: table;
  margin:0 auto;
  padding: 20px;

  background: #fff;

  font-family: 'Roboto', sans-serif;
}
.widget * {margin: 0;}
.widget h3 {
  margin-bottom: 20px;
  text-align: center;
  font-size: 24px;
  font-weight: normal;
  color:  #424949;
}
.widget ul {
  margin: 0;
  padding: 0;
  list-style: none;
  width: 250px;
}
.widget li {
  border-bottom: 1px solid #eaeaea;
  padding-bottom: 15px;
  margin-bottom: 15px;
}
.widget li:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}
.widget a {
  text-decoration: none;
  color:  #616a6b;
  display: inline-block;
}
.widget li:before {
  font-family: FontAwesome;
  font-size: 20px;
  vertical-align:bottom;
  color: #dd3333; 
  margin-right: 14px;
}
.widget li:nth-child(1):before {content:"\f5ad";}
.widget li:nth-child(2):before {content:"\f0d0";}
.widget li:nth-child(3):before {content:"\f0cd";}
.widget li:nth-child(4):before {content:"\f028";}
.widget li:nth-child(5):before {content:"\f03d";}
</style>




















<div class="widget">
  <ul>
    <li><i data-icon="&#xe37e;"></i><a href="">Дизайн</a></li>
    <li><a href="">Фотошоп</a></li>
    <li><a href="">Типографика</a></li>
    <li><a href="">Музыка</a></li>
    <li><a href="">Видео</a></li>
  </ul>
</div>

</br ></br >
</div>
</div>
</div>
		</div>
		<div class="inner screen-4">

		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
<?php } ?>
		
		
		
		
		
		
		
		<div class="inner screen-5">
			<div class="copyright">
				Lineage II and Lineage II the Chaotic Throne are registered trademarks of NCsoft Corporation. Developed by Lineage II Development Studio in NCsoft. 2003-2017 (C) Copyright NCsoft Corporation. All Right Reserved
			</div>
			<ul class="banners">
				<li><img src="http://www.free-kassa.ru/img/fk_btn/15.png"></li>
				<li><img src="http://www.free-kassa.ru/img/fk_btn/15.png"></li>
			</ul>
			<a href="https://coolness.su" class="coolness" target="blank"></a>
		</div>
	</div>
</div>

<div class="error-block"></div>
<?php if(CAuth::isLoggedInAsAdmin()): ?>
    <div id="charm-panel" class="no-display">
        <div class="side-ui">
            <div class="header">
                <h3><?php echo My::t('app', 'Control Panel'); ?></h3>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="post/"><?php echo My::t('app', 'Add post'); ?></a></li>
                    <li><a href="menu/admin"><?php echo My::t('app', 'Manage menu'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="store/admin"><?php echo My::t('app', 'Store'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="skills/admin"><?php echo My::t('app', 'Skills'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/role-edit"><?php echo My::t('app', 'Character editor'); ?></a></li>
                    
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="icon/admin"><?php echo My::t('app', 'Submitting a faction logo'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/user-info"><?php echo My::t('app', 'User info'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/forbid"><?php echo My::t('app', 'Forbid manager'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/send-mail"><?php echo My::t('app', 'Send mail to game'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/send-message"><?php echo My::t('app', 'Broadcast message'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/userPriv"><?php echo My::t('app', 'Менеджер привилегий'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="automessage/"><?php echo My::t('app', 'Автоматические сообщения'); ?></a></li>
                </ul>
            </div>
            <div class="footer">
                <a onclick="return go(this, event, CharmBar.panelHide());" href="admin/settings">
                    <i data-icon="&#xe202;"></i>
                    <label><?php echo My::t('app', 'System configuration'); ?></label>
                </a>
                <a onclick="return go(this, event, CharmBar.panelHide());" href="admin/server-management">
                    <i data-icon="&#xe38b;"></i>
                    <label><?php echo My::t('app', 'Server management'); ?></label>
                </a>
                <a onclick="return go(this, event, CharmBar.panelHide());" href="admin/online">
                    <i data-icon="&#xe029;"></i>
                    <label><?php echo My::t('app', 'Online characters'); ?></label>
                </a>
                <a onclick="ajax.send('POST', 'admin/ajax', {act:'clear_cache'}, null, function(r) { alert(r); CharmBar.panelHide(); });" href="javascript:void(0);">
                    <i data-icon="&#xe0fb;"></i>
                    <label><?php echo My::t('app', 'Clear MyWeb cache'); ?></label>
                </a>
                <a onclick="ajax.send('POST', 'admin/ajax', {act:'leaderboard'}, null, function(r) { localtion.reload(); });" href="javascript:void(0);">
                    <i data-icon="&#xe019;"></i>
                    <label><?php echo My::t('app', 'Обновить персонажей'); ?></label>
                </a>
                <!--<a onclick="ajax.send('POST', 'admin/ajax', {act:'battleload'}, null, function(r) { localtion.reload(); });" href="javascript:void(0);">
                    <i data-icon="&#xe019;"></i>
                    <label><?php echo My::t('app', 'Обновить кланы'); ?></label>
                </a>-->
            </div>
        </div>
        <div class="mask-ui" onclick="CharmBar.panelHide();"></div>
    </div>
<?php endif; ?>
<div id="page-layout">
    <div class="message-box">
        <div class="message-box-header"></div>
        <div class="message-box-content"></div>
        <div class="message-box-footer"></div>
    </div>

</div>








<script Language="JavaScript">
var hours = <?php echo date("H"); ?>;
var min = <?php echo date("i"); ?>;
var sec = <?php echo date("s"); ?>;
function display() {
sec+=1;
if (sec>=60)
{
min+=1;
sec=0;
}
if (min>=60)
{
hours+=1;
min=0;
}
if (hours>=24)
hours=0;


if (sec<10)
sec2display = "0"+sec;
else
sec2display = sec;


if (min<10)
min2display = "0"+min;
else
min2display = min;

if (hours<10)
hour2display = "0"+hours;
else
hour2display = hours;

document.getElementById("seconds").innerHTML = hour2display+":"+min2display+":"+sec2display;
setTimeout("display();", 1000);
}

display();
</script>

</body>
</html>
