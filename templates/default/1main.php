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
	<link rel="stylesheet" media="all" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.8.1/css/pro.min.css">
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

<div class="name yellow-grad flex-sbc">
<a href="user/login" 
class="text yellow-grad-text" 
style="width: 100%;padding-right: 15px;top: 7px;position: relative;
color: #fff;opacity: 1;text-decoration: none;font-size: 14px">РЕГИСТРАЦИЯ | ВХОД</a>
</div>
  <?php endif ?>
        <?php if(CAuth::isLoggedIn()): ?>



<div class="name yellow-grad flex-sbc">
<a href="account/settings" 
class="text yellow-grad-text" 
style="width: 100%;padding-right: 15px;padding-top: 5px;position: relative;
color: #fff;opacity: 1;text-decoration: none;">Кабинет: <?php echo CAuth::getLoggedParam('loggedName'); ?></a>
</div>
<!--=====================================================================
			<li class="left-float white _h" tabindex="0" role="button" onfocus="CharmBar.roles(this);" selected-role="<?php echo CAuth::getLoggedParam('selectedRoleId'); ?>">
                <div class="inner-link"><?php echo My::t('app', 'Characters'); ?></div>
                <div class="bottom-line"></div>
                <div class="toggle-flyout right no-tail" style="top: 38px; width: 200px;">
                    <table class="user-roles"></table>
                </div>
            </li>
=====================================================================-->	
			
			
			
			
			
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
				<div class="text-1">Начните игру<br> Forsaken World<br><span>Arcadia PvE x1</span></div>
				<div class="text-2">
					Еще больше крутых обновлений и игровых систем<br><span>ПвЕ сервер для вас</span> - <span>пора захватывать мир Эйры</span><br>
				</div>
			</div>
<?php
// конфиги
$config = array
(

        'ip'    =>    '127.0.0.1',
        'port'    =>    '29001',
);

        $fp = @fsockopen($config['ip'], $config['port'], $errno, $errstr, 1);
    if($fp >= 1)
        {$status = 'online';}
    else
        {$status = 'offline';}
// кол-во в сети
        $online = mysql_query("select count(*) from point where zoneid='1'");
        $on = mysql_fetch_row($online);
        $on[0] = $on[0];

// вывод на страницу
echo <<<html




<b class="timeserver" style="width: 100%;text-align: center;font-family: Beaufort;font-size: 24px;color: #c11515;left: -10px;right: 0;margin: auto;">Статус:
			<span class="$status" style="width: 100%;text-align: center;font-family: Beaufort;font-size: 24px;">$status</span>
			<p id="seconds" style="width: 100%;text-align: center;font-family: Beaufort Bold;font-size: 46px;color: #562200;">
			0</p></b>
			
html;
?>
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
				
				




			<?php if(CConfig::get('components.sidebar.enable')): ?>
            <?php echo Sidebar::init()->playerLeaderboards(true); ?>
			<?php endif; ?>			
				
				
				



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
<div class="side-left side-content2" style="border-radius: 3px;width: 78%;box-shadow: 0 10px 20px rgba(0,0,0,0.1);border: none;">
<div style="border-top: 3px solid #e55454;top: 30px;position: relative;" ></div >
<div id="lastpost2" style="width: 90%;">
<div id="left-content-area">
	<?php echo My::app()->view->getContent(); ?>
</div>
	</br ></br >
</div>
</div>
<?php if(CAuth::isLoggedIn()): ?>
<div class="side-right side-content2" style="border-radius: 8px;width: 20%;border: none;background: none;">
<div id="lastpost2">

<div class="container2" style="box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
<nav>
		<ul class="mcd-menu">


            <?php if(CAuth::getLoggedParam('selectedRoleId')): ?>
                <li class="left-float white _h" tabindex="0" role="button" style="position: absolute;top: -67px;background: linear-gradient(to top, #e55454, #e55454);width: 250px;">
                    <span class="role-avatar role-cls s25 cls-<?php echo CAuth::getLoggedParam('selectedRoleCls'); ?> left-float" ></span>
					<label style="font-family: Beaufort Bold;font-size: 20px;color: #fff;top: 1px;position: relative;padding-left: 10px;">
					<?php echo CAuth::getLoggedParam('selectedRoleName'); ?></label>
                    <!--<div class="bottom-line"></div>
                    <div class="toggle-flyout left no-tail" style="top: 38px; width: 320px;">
                        <table class="role-info">
                            <tr>
                                <td colspan="2" style="text-align: center;"><a href="/level-boost/" onclick="return go(this, event);"><?php echo My::t('app', 'Level boost'); ?></a></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;"><a href="exchange/cubigold" onclick="return go(this, event);"><?php echo My::t('app', 'Exchange of MyWeb coins for cubigold'); ?></a></td>
                            </tr>
                        </table>
                    </div>-->
                </li>
            <?php endif; ?>



            <li class="left-float white _h" tabindex="0" role="button" onfocus="CharmBar.roles(this);" selected-role="<?php echo CAuth::getLoggedParam('selectedRoleId'); ?>" style="position: absolute;top: -37px;">
                <div class="name yellow-grad flex-sbc" style=" border-radius: revert;cursor: pointer;background: linear-gradient(to top, #e55454, #e55454);width: 250px;height: 35px;">
				<div class="text yellow-grad-text inner-link" style="top: 7px;position: relative;padding-left: 10px;color: #fff;font-size: 18px;">Выбрать: Персонажа</div>
				</div>
                <div class="bottom-line"></div>
                <div class="toggle-flyout right no-tail" style="top: 38px; width: 250px;"">
                    <table class="user-roles"></table>
                </div>
            </li>
<style>
.exit {
	position: absolute;top: 40px;left: 180px;cursor: pointer;color: #777;
}
.exit:hover {
	color: #e55454;
}
</style>
			<li>
				<mc style="box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
					<i class="fab fa-earlybirds"></i>
					<strong>Привет: <?php echo CAuth::getLoggedParam('loggedName'); ?></strong>
					<small>Ваш баланс: <?php echo User::model()->findByPk(CAuth::getLoggedId())->coins; ?> ₽</small>
				</mc>
				<span class="exit" onclick="window.location.href='user/logout';" >
				<i class="fab fa-expeditedssl"></i> Выход</span>

			</li>
		</ul>
	</nav>
</div>



<div class="container" style="box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
<nav>
		<ul class="mcd-menu">
			<li>
				<a href="account/settings" <?php if($_SERVER['REQUEST_URI'] == '/account/settings') { ?>class="active"<?php } ?> >
					<i class="fa fa-edit"></i>
					<strong>Настройки</strong>
					<small>Редактирование</small>
				</a>
			</li>
			<li>
				<a href="account/addfunds"  <?php if($_SERVER['REQUEST_URI'] == '/account/addfunds') { ?>class="active"<?php } ?> >
					<i class="fas fa-wallet"></i>
					<strong>Баланс</strong>
					<small>Монет: <span style="color: #e67e22;"><?php echo User::model()->findByPk(CAuth::getLoggedId())->coins; ?></span></small>
				</a>
			</li>
			<li>
				<a href="account/vote" <?php if($_SERVER['REQUEST_URI'] == '/account/vote') { ?>class="active"<?php } ?> >
					<i class="fa fa-bullhorn"></i>
					<strong>Голосовать</strong>
					<small>Поддержи сервер Fw-Arcadia</small>
				</a>
			</li>
			<li>
				<a href="exchange/cubigold" <?php if($_SERVER['REQUEST_URI'] == '/exchange/cubigold') { ?>class="active"<?php } ?> >
					<i class="fab fa-envira"></i>
					<strong>Листья Эйры</strong>
					<small>Перевод монет в игру</small>
				</a>
			</li>
			<li>
				<a href="store/index" <?php if($_SERVER['REQUEST_URI'] == '/store/index') { ?>class="active"<?php } ?> >
					<i class="fas fa-shopping-basket"></i>
					<strong>Магазин</strong>
					<small>Покупка предметов за монеты</small>
				</a>
			</li>
			<li>
				<a href="account/allactivity" <?php if($_SERVER['REQUEST_URI'] == '/account/allactivity') { ?>class="active"<?php } ?> >
					<i class="fa fa-clipboard"></i>
					<strong>Журнал действий</strong>
					<small>Логи аккаунта</small>
				</a>
			</li>
			<li>
				<a href="account/referral" <?php if($_SERVER['REQUEST_URI'] == '/account/referral') { ?>class="active"<?php } ?> >
					<i class="fa fa-users"></i>
					<strong>Реферальная систем</strong>
					<small>Приглашайте своих друзей</small>
				</a>
			</li>

		</ul>
	</nav>
</div>


</br ></br >
</div>
</div>
<?php else: ?>
			<div class="side-right side-content" style="height: 640px;width: 270px; border: none;">
				<div class="title"><span>МЫ</span> ВКОНТАКТЕ</div>
				<div class="desc">Общайтесь с нами в социальной сети!</div>
				
<!-- Модуль Темы с Форума -->
<div id="lastpost">


<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 4, width: "270", height: "530"}, 81128111);
</script>
</div>

			</div>
		<?php endif ?>







</div>
		</div>
		<div class="inner screen-4">

		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
<?php } ?>
		
		
		
		
		
		
		
		<div class="inner screen-5">
			<div class="copyright">
				Хотите всегда быть в курсе последних новостей Forsaken World? Подпишитесь на нашу страницу <a href="https://vk.com/fwarcadia" target="blank" >Вконтакте</a> и обсуждайте с другими игроками последние новости и обновления, которые ждут вас в игре!
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
                <a onclick="ajax.send('POST', 'admin/ajax', {act:'battleload'}, null, function(r) { localtion.reload(); });" href="javascript:void(0);">
                    <i data-icon="&#xe019;"></i>
                    <label><?php echo My::t('app', 'Обновить кланы'); ?></label>
                </a>
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
