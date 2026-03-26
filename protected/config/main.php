<?php

return array(
    // application data
    'name'=>'FW-Arcadia',
    'version'=>'1.0.0',

    // installation settings
    'licenseKey'=>'22129637-5F4FA950-13039203-B7C1549B',
    'installationKey'=>'fq1DtWb8Xst0WnCQ',

    // password keys settings
    'password'=>array(
        'encryption'=>true,
        'encryptAlgorithm'=>'md5', /* md5, base64 */
        'hashKey'=>'myweb',
    ),


'news_db'=>'myweb',
'news_pass'=>'123456',
'news_user'=>'root',
'news_host'=>'127.0.0.1',


    // default email settings
    'email'=>array(
        'mailer'=>'phpMailer', /* 'phpMail', 'phpMailer', 'smtpMailer' */
        'from'=>'info@email.me',
        'isHtml'=>true,
        'smtp'=>array(
            'auth'=>1,
            'secure'=>'ssl', /* 'ssl', 'tls', '' */
            'host'=>'smtp.gmail.com',
            'port'=>'465',
            'username'=>'',
            'password'=>'',
        ),
    ),

    // validation and captcha
    'validation'=>array(
        'csrf'=>true,
        'bruteforce'=>array('enable'=>true, 'badLogins'=>5, 'redirectDelay'=>3),
        'captcha'=>array(
            'login'=>false,
            'join'=>true,
            'recovery'=>true,
            'length'=>3,
            'fontPath'=>'/fonts/Gorillaz/gorillaz_1.ttf'
        ),
    ),

    // session settings
    'session'=>array(
        'cacheLimiter'=>'' /* private,must-revalidate */
    ),

    // cookies settings
    'cookies'=>array(
        'domain'=>'fw-arcadia.ru',
        'path'=>'/'
    ),

    // cache settings
    'cache'=>array(
        'enable'=>true,
        'lifetime'=>5,
        'path'=>'protected/tmp/cache/',
    ),

    // time settings
    'defaultTimeZone'=>'Europe/Moscow',
    // application settings
    'defaultTemplate'=>'default',
    'defaultController'=>'Index',
    'defaultAction'=>'index',

    // application components
    'components'=>array(
        'sidebar'=>array('enable'=>true, 'class'=>'Sidebar'),
    ),


    // application modules
    'modules'=>array(
        'admin'=>array('enable'=>true, 'classes'=>array('Admin')),
    ),

    // url manager
    'urlManager'=>array(
        'urlFormat'=>'shortPath', /* get | path | shortPath */
        'rules'=>array(
            'level-boost'=>'service/levelboost',
            //'clear-storehouse-password'=>'service/clearstorehousepassword',
            //'reset-spirit'=>'service/resetspirit',
            'chat-broadcast'=>'service/chatbroadcast',
            //'change-cultivation'=>'service/changecultivation',
            //'safe-place-teleport'=>'service/safeplaceteleport',
            //'reset-experience'=>'service/resetexperience',
            //'rename-character'=>'service/renamecharacter',
            //'add-cells'=>'reforge/addcells',
            //'attack-range'=>'reforge/attackrange',
            //'distance-fragility'=>'reforge/distancefragility',
            //'attack-speed'=>'reforge/attackspeed',
            //'item-creator'=>'reforge/itemcreator',
        ),
    ),

    /**
	|--------------------------------------------------------------------------
	| Полный путь до директории /mywebapi
	|--------------------------------------------------------------------------
	| Закрывающий слэш обязателен, пример: http://<SERVER_IP>/mywebapi/
	*/
	
    'apiUrl'=>'http://192.168.1.4/m_fwapi/',
	
	/**
	|--------------------------------------------------------------------------
	| IP адрес сервера
	|--------------------------------------------------------------------------
	| Используется для статистики "Статус сервера"
	*/
	
    'serverIp'=>'192.168.1.4', //<SERVER_IP>
	
    /**
	|--------------------------------------------------------------------------
	| Игровой порт
	|--------------------------------------------------------------------------
	| Используется для статистики "Статус сервера"
	*/
	
	'serverPort'=>29001,
	
    /**
	|--------------------------------------------------------------------------
	| Максимальный онлайн на сервере
	|--------------------------------------------------------------------------
	| Используется для статистики "Нагрузка на сервер"
	*/
	
	'max_online'=>800,

    /**
	|--------------------------------------------------------------------------
	| Настройки платежной системы
	|--------------------------------------------------------------------------
	| Используется для статистики "Нагрузка на сервер"
	*/
	
    'payment'=>array(
        // payment factor (ex.: $1 = 2 myweb coin)
        'value'=>1,

        // minimum and maximum payment amount
        'min_amount'=>1,
        'max_amount'=>5000,

        // use bonuses
        'bonus'=>false,
        'bonuses'=>array(
            array('step'=>1000, 'factor'=>2.0), // Увелечение дона
            // more
        )
    ),

    // Unitpay merchant area settings (https://unitpay.ru/)
    'unitpay'=>array(
        'enable'=>false,
        'form'=>'https://unitpay.ru/pay/00000-00000',
        'desc'=>'Добровольное пожертвование Maridan'
    ),

    // Free-Kassa merchant area settings (http://www.free-kassa.ru/)
    'freekassa'=>array(
        'enable'=>true,
        'merchant_id'=>'51753',
        'secret_key'=>'0c8xa2wm',
        'secret_key_result'=>'d89oh6ia',
    ),

    // Players and factions ratings settings (Sidebar)
    'leaderboards'=>array(
        'roles'=>array(
            'criteria'=>'level,pkvalue',
            'limit'=>10,
            'bad'=>'16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,12544'
        ),
        'factions'=>array(
            'limit'=>5,
        )
    ),

    // Команда сервера (Sidebar)
	'staff'=>array(
       11872=>array('character'=>'Qwerty', 'role'=>'Главный ADMIN'),
		4160=>array('character'=>'Mars', 'role'=>'Зам.Главн. ADMIN'),
		25872=>array('character'=>'GMInvent', 'role'=>'GM Ивентор'),
    ),

    /**
	|--------------------------------------------------------------------------
	| Реферальная система
	|--------------------------------------------------------------------------
	| 'enable'=>true - Параметр включен
	| 'enable'=>false - Параметр отключен
	| 'id' - НОМЕР предмета в магазине (НЕ ID предмета)
	| 'count' - количество предметов
	| 'requirements' - требования
	*/
    'referral'=>array(
        'enable'=>true,
        /**
		|--------------------------------------------------------------------------
		| Пожертвования
		|--------------------------------------------------------------------------
		| Когда последователь делает пожертвование, рефералу дается процент от суммы.
		*/
		'donation'=>array(
            'enable'=>true, /** true\false - вкл\выкл */
            'amount'=>1,	 /** Требуемая минимальная сумма */
            'percent'=>5	 /** Процент от суммы */
        ),
		/**
		|--------------------------------------------------------------------------
		| Игровые предметы
		|--------------------------------------------------------------------------
		| Когда последователь достигает необходимого уровня (параметры добавляются на заказ), рефералу и последователю выдаются предметы на аккаунт.
		*/
        'ingameitems'=>array(
            'enable'=>false,
            /**
			|--------------------------------------------------------------------------
			| Подарки рефералу
			|--------------------------------------------------------------------------
			| 1. ПОСЛЕДОВАТЕЛЬ должен иметь 105 уровень, а затем РЕФЕРАЛ может получить этот предмет
			| 2. ПОСЛЕДОВАТЕЛЬ должен достичь 150 уровень после ПЕРЕРОЖДЕНИЯ, а затем РЕФЕРАЛ может получить этот предмет
			*/
			'referral'=>array(
                array('id'=>0, 'count'=>1, 'requirements'=>array('level'=>150)),
            ),
			/**
			|--------------------------------------------------------------------------
			| Подарки последователю
			|--------------------------------------------------------------------------
			| 1. Выдается сразу.
			| 2. ПОСЛЕДОВАТЕЛЬ должен иметь 50 уровень, чтобы получить этот предмет.
			| 3. ПОСЛЕДОВАТЕЛЬ должен иметь 100 уровень, чтобы получить этот предмет.
			*/
            'follower'=>array(
				array('id'=>0, 'count'=>1, 'requirements'=>array('level'=>150)),
				array('id'=>0, 'count'=>1, 'requirements'=>array('level'=>150)),
            ),
        ),
    ),

    // guildicons
    'guildicons'=>array(
        'size_x'=>2048,
        'server_id'=>1
    ), 

    /*
    |--------------------------------------------------------------------------
    | Chat event
    |--------------------------------------------------------------------------
    |
    */

    'chatevent'=>[
        'secure_key'=>'Hzg68qU'
    ],
);