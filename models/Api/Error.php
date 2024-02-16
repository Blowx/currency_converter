<?php

namespace application\models\Api;

use application\models\Defines;


class Error extends \Exception
{
    /**
     * @param   integer $code        Error code to return text for
     * @param bool|true $includeCode Flag indicating weather if code should be included
     *
     * @return string
     */
    public static function getErrorText($code, $includeCode = true)
    {
        $text = Defines\Api\Error::getText($code);
        if ($includeCode) {
            $text = "[{$code}] {$text}";
        }

        return $text;
    }

    /**
     * Creates new instance of Api\Error by specified Error Code
     * preparing Error message
     *
     * @param   number $code  Code of error to prepare
     * @param   mixed  $param Additional parameter to be added/replaced in Error Message (optional)
     *
     * @return  Error
     */
    public static function create($code, $param = null)
    {

        $text = self::getErrorText($code, false);
        if (null === $param) {
            $result = new Error($text, $code);
        } else {
            if (is_object($param) && get_class($param) == 'Exception') {
                /** @var \Exception $param */
                $param = "Exception: [{$param->getCode()}] {$param->getMessage()}";
            }

            $result = new Error(sprintf($text, $param), $code);
        }

        return $result;
    }
}
