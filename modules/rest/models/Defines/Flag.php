<?php


namespace application\modules\rest\models\Defines;

use yii;

class Flag
{
    /**
     * Returns No for empty and Yes for other
     *
     * @param mixed $flag Flag to return string value name for
     *
     * @return string
     */
    public static function yesNo($flag)
    {
        if (empty($flag)) {
            return 'no';
        }

        return 'yes';
    }

    /**
     * Returns False for empty and True for other
     *
     * @param mixed $flag Flag to return string value name for
     *
     * @return string
     */
    public static function trueFalse($flag)
    {
        if (empty($flag)) {
            return 'false';
        }

        return 'true';
    }

    /**
     * Returns Allowed/ NOT allowed
     *
     * @param mixed $flag Flag to return string value name for
     *
     * @return string
     */
    public static function allowed($flag)
    {
        if (empty($flag)) {
            return 'NOT Allowed';
        }

        return 'Allowed';
    }
}
