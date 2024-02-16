<?php

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'timeZone' => 'Europe/Minsk',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'application\commands',
    'aliases' => [
        '@application' => '@app',
    ],
    'modules' => [
    ],
    'components' => [
        'urlManager' => [
            'baseUrl' => 'http://currency',
            'hostInfo' => 'http://currency',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'rules' => include('url_manager_rules.php'),
        ],
        'response' => [
            'class' => 'application\modules\rest\models\ConsoleResponse',
        ],
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'application\commands\MigrateController',
            'migrationTable' => 'tbl_migration',
        ],
    ],
];

if (YII_ENV_TEST) {
    // configuration adjustments for 'test' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
