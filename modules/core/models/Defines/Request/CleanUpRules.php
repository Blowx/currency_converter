<?php

namespace application\modules\core\models\Defines\Request;


/**
 * Class CleanUpRules
 *
 * @package application\modules\rest\models\Defines\Request
 */
class CleanUpRules
{
    /**
     * Rule for xss attack
     */
    const TEXT = 0;
    /**
     * Rule for HTML
     */
    const HTML = 2;
}
