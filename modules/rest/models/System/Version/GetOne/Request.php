<?php

namespace application\modules\rest\models\System\Version\GetOne;

use application\modules\rest\models;

/**
 * Class Request
 *
 * @package application\modules\rest\models\System\Version\GetOne
 */
class Request extends models\Request
{
    /**
     * @inheritdoc
     */
    public function required()
    {
        return [];
    }

}
