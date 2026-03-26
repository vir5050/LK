<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords); ?>" />
    <meta name="description" content="<?php echo CHtml::encode($this->pageDescription); ?>" />
    <base href="<?php echo My::app()->getRequest()->getBaseUrl(); ?>" />
    <title><?php echo CHtml::encode($this->_pageTitle); ?></title>
    <link rel="shortcut icon" href="/" />
    <?php echo CHtml::cssFile('css/reset.css'); ?>
    <?php echo CHtml::cssFile('css/IcoMoon.css'); ?>
    <?php echo CHtml::cssFile('css/Opentip.css'); ?>
    <?php echo CHtml::cssFile('templates/user/css/styles.css?3'); ?>
    <?php echo CHtml::scriptFile('js/vendors/Opentip.js'); ?>
    <?php echo CHtml::scriptFile('templates/default/js/page.js'); ?>
</head>
<body>
<div id="main-wrapper">
    <div class="form-box">
        <?php /*echo CWidget::create('CLanguageSelector', array(
				'languages' => array('en'=>array('name'=>'English', 'icon'=>''), 'ru'=>array('name'=>'Russian', 'icon'=>'')),
				'display' => 'names',
				'imagesPath' => 'images/langs/',
				'currentLanguage' => My::app()->getLanguage(),
				'return' => true
			));*/ ?>
        <?php echo My::app()->view->getContent(); ?>
    </div>
    <div class="copyright"><?php echo My::powered() ?></div>
</div>
</body>
</html>