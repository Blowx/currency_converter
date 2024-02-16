<?php
namespace application\modules\rest\models\Defines\Api;

use application\models\Defines as CoreDefines;

class Error extends CoreDefines\Api\Error
{
    /**
     * NO ERROR - Successful Code
     *
     * @var integer
     */
    const OK = 0;

    const INVALID_REQUEST_DATA = 1;

    const ENTITY_NOT_SAVED = 2;

    const PARAM_NOT_FOUND = 3;

    const CURRENCY_NOT_FOUND = 4;

    const INVALID_AMOUNT = 5;
}
