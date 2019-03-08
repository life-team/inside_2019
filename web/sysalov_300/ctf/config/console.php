<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
	'id' => 'basic-console',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log', 'nord\yii\account\Bootstrap'],
	'controllerNamespace' => 'app\commands',
	'aliases' => [
        '@gisgkh' => '@app/opengkh',
    ],
	'modules' => [
		'account' => [
			'class' => 'nord\yii\account\Module'
		]
	],
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning']
				],
			],
		],
		'db' => $db,
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],
		'queue' => [
			'class' => 'yiisolutions\queue\Queue',
			'host' => '127.0.0.1',
			'port' => 5672,
			'user' => 'admin',
			'password' => 'admin040784',
			'vhost' => '/',
		],
		'comet' => [
			'class' => 'app\components\Comet'
		],
		'notification' => [
			'class' => 'app\components\Notification'
		]
	],
	'params' => $params
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module'
    ];
}

return $config;
