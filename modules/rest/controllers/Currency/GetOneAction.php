<?php

namespace application\modules\rest\controllers\Currency;

use application\modules\rest\controllers;
use application\modules\rest\models;

class GetOneAction extends controllers\DefaultAction
{
    /**
     * Returns action handler instance
     *
     * @return models\Handler|models\Currency\GetOne\Handler
     */
    public function handler(): models\Currency\GetOne\Handler
    {
        return new models\Currency\GetOne\Handler();
    }
}
