<?php

namespace application\modules\rest\models\System\Version\GetOne;

use application\modules\rest\models\System\Version;

/**
 * Class Response
 *
 * @package application\modules\rest\models\System\Version\GetOne
 */
class Response
{
    /**
     * @inheritdoc
     */
    public function prepare()
    {
        return Version\Helper::getApiVersion();
    }
}
