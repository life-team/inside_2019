<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'nord\yii\account\Bootstrap'
    ],
    'language' => 'ru-RU',
	'sourceLanguage' => 'en-US',
    'defaultRoute' => 'index-app',
	'aliases' => [
		'@frontend' => '@app/frontend_app/'
	],
    'modules' => [
        'account' => [
            'class' => 'nord\yii\account\Module',
            'enableCaptcha' => false,
            'viewPath' => '@app/modules/account/views/',
			'controllerMap' => [
				'dashboard' => '\app\modules\account\controllers\DashboardController',
			],
			'classMap' => [
				'account' => '\app\modules\account\models\Account',
				'signupForm' => '\app\modules\account\models\SignupForm',
			],
			'messagePath' => '@app/modules/account/messages/',
			// USER
			'userConfig' => [
				'loginUrl' => '/'
			],
			'params' => [
				'fromEmailAddress' => 'info@vssys.ru'
			]
        ],
        'app' => [
            'class' => '\app\modules\app\Module',
            'viewPath' => '@app/modules/app/views/',
			'controllerMap' => [
				'user' => '\app\modules\app\controllers\UserController'
			]
        ],
    ],
    'components' => [
		'request' => [
			'cookieValidationKey' => '0EGTuThza6PmBz',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'errorHandler' => [
			'errorAction' => 'index/error',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' => true,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => require(__DIR__ . '/db.php'),
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [],
		],
		'authManager' => [
		   'class' => 'app\components\AuthManager'
		],
		'assetManager' => [
			'appendTimestamp' => true,
			'bundles' => [],
		],
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'locale' => 'ru-RU',
			'timeZone' => 'UTC'
		],
		'queue' => [
			'class' => 'yiisolutions\queue\Queue',
			'host' => '90.189.132.25',
			'port' => 5672,
			'user' => 'ctf',
			'password' => 'ctf48845756',
			'vhost' => '/',
		],
		'comet' => [
			'class' => 'app\components\Comet'
		]
    ],
    'controllerMap' => [
        // объявляет "account" контроллер, используя название класса
        //'account' => 'app\controllers\UserController',

        // объявляет "article" контроллер, используя массив конфигурации
        //'article' => [
        //    'class' => 'app\controllers\PostController',
        //    'enableCsrfValidation' => false,
        //],
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
   /* $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
		'allowedIPs' => ['*']
    ];*/
	
    /*$config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1', '192.168.100.1'],
    ];*/
}

if (YII_ENV_PROD || YII_ENV_DEV) {
	$config['components']['mailer']['useFileTransport'] = false;
	$config['components']['mailer']['transport'] = [
		'class' => 'Swift_SmtpTransport',
		'host' => 'ssl://s35.webhost1.ru',
		'username' => 'info@u402482.s35.wh1.su',
		'password' => '5A7d2Y9p',
		'port' => '465',
		'streamOptions' => [ 
			'ssl' => [ 
				'allow_self_signed' => true,
                    		'verify_peer' => false,
                    		'verify_peer_name' => false,
                	],
		]
	];
}

return $config;
