<?php

// NOTE: Make sure this file is not accessible when deployed to production
//if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
//    die('You are not allowed to access this file.');
//}
//defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');
require(__DIR__ . '/TestCase/SimpleTestCase.php');
require(__DIR__ . '/TestCase/DatabaseTestCase.php');


$_SERVER['SCRIPT_FILENAME'] = '';
$_SERVER['SCRIPT_NAME'] = 'test';
$_SERVER['SERVER_NAME'] = 'test';
$_SERVER['SERVER_PORT'] =  '80';
$_SERVER['REQUEST_URI'] =  'test';
$_SERVER['REQUEST_METHOD'] =  'TEST';

$type = 'test';
$config = loadConfig($type);

(new yii\web\Application($config));
date_default_timezone_set('Europe/Minsk');
//$app->run();
