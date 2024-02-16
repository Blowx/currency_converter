<?php

namespace application\models\Defines\Api;

class Error
{

    // NO ERROR - Successful Code
    const OK = 0;
    // Special UNKNOWN error for unprocessed cases
    const INTERNAL = -1;

    /**
     * Returns error code description
     *
     * @param integer $code Error code
     *
     * @return string
     */
    public static function getText($code)
    {
        return \Yii::t('api', "API_ERROR_{$code}");
    }
}
