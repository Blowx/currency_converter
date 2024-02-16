<?php
namespace application\models;

class Error extends \Exception
{
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
        if (Defines\Api\Error::INTERNAL == $code) {
            $text = 'Internal Error. Contact support team';
        } else {
            $text = Defines\Api\Error::getText($code);
        }
        $class = get_called_class();

        return new $class(sprintf($text, $param), $code);
    }
}
