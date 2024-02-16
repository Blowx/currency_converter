<?php

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'aliases' => [
        '@application' => '@app',
    ],
    'bootstrap' => [
        'log',
    ],
    'modules' => [
    ],
    'components' => [
        'view' => [
            'theme' => [
//                'basePath' => dirname(__DIR__),
                'basePath' => '@webroot/themes/default',
                'baseUrl' => '@web/themes/default',
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'QaNoJeZZ_QjDLKAOSDFSAIAd_1-ksdfI',
            'enableCsrfValidation' => false,
            'baseUrl' => 'test.currency'
        ],
        'assetManager' => [
            'bundles' => [
                // you can override AssetBundle configs here
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => []
                ],
                'yii\jui\JuiAsset' => [
                    'js' => []
                ]
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [],
        ],
        'response' => [
            'class' => 'application\modules\rest\models\ConsoleResponse'
        ],
    ],
    'basePath' => dirname(__DIR__),
];
