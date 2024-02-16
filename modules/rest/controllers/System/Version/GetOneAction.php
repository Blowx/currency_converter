<?php

namespace application\modules\rest\controllers\System\Version;

use application\modules\rest\controllers;
use application\modules\rest\models;

class GetOneAction extends controllers\DefaultAction
{
    /**
     * Returns action handler instance
     *
     * @return models\System\Version\GetOne\Handler
     */
    public function handler()
    {
        return new models\System\Version\GetOne\Handler();
    }
}
