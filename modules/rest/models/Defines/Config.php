<?php

namespace application\modules\rest\models\Defines;

use application\models\Defines as CoreDefines;

/**
 * Class Config
 *
 * @package application\modules\rest\models\Defines
 */
class Config extends CoreDefines\Config
{
    /**
     * Default limit for data(Limit data for response by request)
     *
     * @var integer
     */
    const DEFAULT_DATA_LIMIT = 50;
}
