<?php

require_once __DIR__ . '/helper.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'timeZone' => 'Europe/Minsk',
    'modules' => [
        'rest' => array(
            'class' => 'application\modules\rest\Module',
        ),
        'web' => array(
            'class' => 'application\modules\web\WebModule',
        ),
    ],
    'components' => [
        'view' => [
            'theme' => [
                'basePath' => dirname(__DIR__),
//                'basePath' => '@webroot/themes/default',
                'baseUrl' => '@web/themes/default',
            ],
        ],
        'request' => [

            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'CzMiJYKO_UHll1eNR18xDUwL-3_qdxJ7',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/scim+json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => 'application\modules\rest\models\WebResponse',
        ],
        'user' => [
            'class' => 'application\components\WebUser',
            'identityClass' => 'application\modules\rest\models\Entity\User',
            'enableAutoLogin' => true,
        ],
        'assetManager' => [
            'bundles' => [
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => include('url_manager_rules.php'),
        ],
    ],
];

if (YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
