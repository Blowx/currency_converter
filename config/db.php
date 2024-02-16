<?php
require_once __DIR__ . '/helper.php';

$host = getEnvVal('CRNC_MYSQL_HOST');
$port = getEnvVal('CRNC_MYSQL_PORT');
$base = getEnvVal('CRNC_DB_NAME');
$user = getEnvVal('CRNC_DB_USERNAME');
$pass = getEnvVal('CRNC_DB_PASSWORD');

return [
    'class' => 'application\modules\yii\db\Connection',
    'commandClass' => 'application\modules\yii\db\Command',
    'dsn' => 'mysql:host=' . $host . ':' . $port . ';dbname=' . $base,
    'username' => $user,
    'password' => $pass,
    'charset' => 'utf8',
    'attributes' => [
        PDO::ATTR_TIMEOUT => 300,
    ],
];
