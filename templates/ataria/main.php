<?php $request = My::app()->getRequest(); ?>
<?php $sidebar = Sidebar::init(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo My::app()->charset; ?>" />
	<title><?php echo CHtml::encode($this->_pageTitle); ?></title>
	<meta name="description" content="<?php echo CHtml::encode($this->_pageDescription); ?>" />
	<meta name="keywords" content="<?php echo CHtml::encode($this->_pageKeywords); ?>" />
	<meta name="author" content="Ataria">
	<base href="<?php echo $request->getBaseUrl(); ?>" />
	<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=no" />
	<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700|Raleway:300,400,500,600,700,800,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<?php echo CHtml::cssFile('css/reset.css'); ?>
	<?php echo CHtml::cssFile('css/IcoMoon.css'); ?>
	<?php echo CHtml::cssFile('css/Opentip.css'); ?>
	<?php echo CHtml::scriptFile('js/vendors/Opentip.js'); ?>
	<link rel="stylesheet" href="/templates/ataria/css/styles.css?2">
	<link rel="stylesheet" href="/templates/ataria/css/main.css?3">
	<link rel="stylesheet" href="/templates/ataria/css/adaptive.css?2">
	<link rel="stylesheet" href="/css/fancybox.css">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
<div id="page-container">
	<div class="headerbg">
		<div class="wrapper">

			<div class="button" style="white-space: nowrap;">

				<?php if (CAuth::isLoggedIn()): ?>
				<div role="button" onclick="CharmBar.roles(this);" selected-role="<?php echo CAuth::getLoggedParam('selectedRoleId'); ?>">
					Выбор персонажа
		            <div id="user-roles" style="position: absolute;">
		                <table class="user-roles"></table>
		            </div>
		        </div>
				<a href="icon/">Логотип гильдии</a>
				<a href="exchange/">Купить слитки</a>
				<a href="/promocode/activate">Промокоды</a>
				<a href="/account/referral">Пригласить</a>
				<?php if(CAuth::isLoggedInAsAdmin()): ?><a onclick="CharmBar.panelShow();">Админка</a><?php endif; ?>
                <?php else: ?>
                <a href="https://atariagame.com/launcher/patcher.zip">Загрузить патч</a>
				<a href="/user/join">Создать аккаунт</a>
                <?php endif; ?>

			</div>

			<div class="lang">
				<a href=""><img src="images/ru.jpg" alt=""></a>
				<a href=""><img src="images/en.jpg" alt=""></a>
			</div>

			<div class="clr">	</div>

		</div>
	</div>


	<div class="wrapper">
		
		<div class="menubg">
                    <?php $noticeCount = (int)Notice::model()->countByAttributes(array('account_id'=>CAuth::getLoggedId())); ?>
                    <div class="left-float _h" tabindex="0" role="button" onfocus="CharmBar.notifications(<?php echo $noticeCount; ?>, this);" style="position: relative;top: 22px;left: 80px;font-size: 18px;cursor: pointer;">
                        <div class="jewels-count" data-count="<?php echo $noticeCount; ?>"></div>
                        <i data-icon="&#xe37e;"></i>
                        <div class="toggle-flyout" style="width: 330px;">
                            <div class="toggle-flyout-header">
                                <h3><?php echo My::t('app', 'Notifications'); ?></h3>
                            </div>
                            <ul class="toggle-flyout-content" style="width: 100%;"></ul>
                        </div>
                    </div>
			<ul>
				<li><a href="">Главная</a></li>
				<li><a href="https://movies.atariagame.com/">Кино онлайн</a></li>
				<li><a href="https://forum.atariagame.com">форум</a></li>
				<?php if (!CAuth::isLoggedIn()): ?>
				<li><a href="/user/join">Регистрация</a></li>
				<li><a href="/user/login">Кабинет</a></li>
				<?php else: ?>
				<li><a href="account/addfunds" style="white-space: nowrap;">Пополнить счет</a></li>
				<li><a style="color: #FFFF2E;pointer-events: none;text-shadow: 0 1px 0 #a07a0f;">Баланс: <?php echo User::model()->findByPk(CAuth::getLoggedId())->coins; ?></a></li>
                <li><a href="user/logout">Выход</a></li>
				<?php endif; ?>

				

			</ul>


		</div>

		<div class="head">
			
			<div class="spoiler_links">Навигация по сайту</div>
<div class="spoiler_body"><ul>
				<li><a href="">Главная</a></li>
				<li><a href="https://movies.atariagame.com/">Кино онлайн</a></li>
				<li><a href="">Статистика</a></li>
				<li><a href="/user/join">Регистрация</a></li>
				<li><a href="/user/login">Кабинет</a></li>
				<li><a href="">Статистика</a></li>
				<li><a href="https://forum.atariagame.com">Форум</a></li>
			</ul></div>

			<a href="" class="logo"></a>

			<a href="https://forum.atariagame.com/threads/kak-nachat-igrat.123/" class="start">Начать игру</a>

		</div>


<div class="container">
	
	<div class="leftbar">
		<?php

		echo $this->getContent(); 

		?>
	</div>

<div class="rightbar">



	
	<div class="block">
		<div class="title">
			<div class="ico-top"></div>
			<span id="tabtitle">Лучшие игроки</span>
		</div>
		<div id="tabvanilla" class="widget">

			<div id="roles" class="tabdiv">
				<div class="head">
					<div class="n"></div>
					<div class="name">Имя персонажа</div>
					<div class="col1">Уровень</div>
					<div class="col2">Онлайн</div>
				</div>
				<?php //echo $sidebar->roles(true); ?>
			</div>
			
			<div id="factions" class="tabdiv">
				<div class="head">
					<div class="n"></div>
					<div class="name">Гильдия</div>
					<div class="col1">Уровень</div>
					<div class="col2">Участники</div>
				</div>
				<?php //echo $sidebar->factions(true); ?>
			</div>

			<ul class="tabnav">
				<li><a href="#roles" data-title="Лучшие игроки">Топ игроков</a></li>
				<li><a href="#factions" data-title="Лучшие гильдии">Топ гильдий</a></li>
			</ul>
		</div>
	</div>



</div>


<div class="clr"></div>
</div>


	</div>


<div class="footer">
	<div class="wrapper">
		
		<div class="copy">Атариа 2016-2019. Данная версия игры предназначена исключительно для ознакомления. Все права принадлежат ©Perfect World Entertainment Inc. Издатель Perfect World Entertainment.</div>

<div class="banner">
	<ul>
		<li><a href="//www.free-kassa.ru/"><img src="//www.atariagame.com/templates/ataria/images/13.png"></a></li>
		<li><a href="https://all.mmotop.ru/servers/29987" target="_blank">
  <img src="https://atariagame.com/images/mmo_29987.png" border="0" id="mmotopratingimg" alt="Рейтинг серверов mmotop">
</a>
<script type="text/javascript">document.write("<script src='http://js.mmotop.ru/rating_code.js?" + Math.round((((new Date()).getUTCDate() + (new Date()).getMonth() * 30) / 7)) + "_" + (new Date()).getFullYear() + "' type='text/javascript'><\/script>");</script></li>
		<li><a href="https://topg.org/games/in-509235" target="_blank"><img src="https://atariagame.com/images/topg.gif" width="88" height="30" border="0" alt="games"></a></li>
		<li></li>
	</ul>
</div>

<div class="clr"></div>
	</div>
</div>

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
                    <li><a href="/promocode/admin">Промокоды</a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="store/admin"><?php echo My::t('app', 'Store'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="skills/admin"><?php echo My::t('app', 'Skills'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/role-edit"><?php echo My::t('app', 'Character editor'); ?></a></li>
                    <li><a class="disabled" href="admin/pretty-role-edit"><?php echo My::t('app', 'Visual character editor'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="icon/admin"><?php echo My::t('app', 'Submitting a faction logo'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/user-info"><?php echo My::t('app', 'User info'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/forbid"><?php echo My::t('app', 'Forbid manager'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/send-mail"><?php echo My::t('app', 'Send mail to game'); ?></a></li>
                    <li><a onclick="return go(this, event, CharmBar.panelHide());" href="admin/send-message"><?php echo My::t('app', 'Broadcast message'); ?></a></li>
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
                    <label><?php echo My::t('app', 'Очистить кэш'); ?></label>
                </a>
                <a onclick="ajax.send('POST', 'admin/ajax', {act:'leaderboard'}, null, function(r) { localtion.reload(); });" href="javascript:void(0);">
                    <i data-icon="&#xe019;"></i>
                    <label><?php echo My::t('app', 'Обновить рейтинги'); ?></label>
                </a>
            </div>
        </div>
        <div class="mask-ui" onclick="CharmBar.panelHide();"></div>
    </div>
<?php endif; ?>
</div>
<div id="page-layout">
    <div class="message-box">
        <div class="message-box-header"></div>
        <div class="message-box-content"></div>
        <div class="message-box-footer"></div>
    </div>
</div>
<script type="text/javascript">var price_labels = [<?php echo My::t('app', 'coin_declinations'); ?>];</script>

	<script type="text/javascript">var price_labels = [<?php echo My::t('app', 'coin_declinations'); ?>];</script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="/js/vendors/fancybox.js"></script>
	<script type="text/javascript" src="/templates/ataria/js/jquery-ui-personalized-1.5.2.packed.js"></script>
	<script type="text/javascript" src="/templates/ataria/js/sprinkle.js"></script>
	<script type="text/javascript" src="/templates/ataria/js/page.js?2"></script>
	<script src="/templates/ataria/js/main.js?<2"></script>
</body>
</html>