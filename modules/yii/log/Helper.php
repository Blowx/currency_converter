<?php
namespace application\modules\yii\log;

use yii;

class Helper
{
    /**
     * Logs specified Exception with message provided
     *
     * @param \Exception $error   Error to log
     * @param  string    $message Additional message
     *
     * @return string
     */
    public static function logError(\Exception $error, $message, $prefix)
    {
        $text = '';
        if ($prefix) {
            $text = "{$prefix}: ";
        }
        $text .= "[{$error->getCode()}] {$error->getMessage()}";
        if ($message) {
            $text .= ". {$message}";
        }
        Yii::warning($text);

        return $text;
    }
}
