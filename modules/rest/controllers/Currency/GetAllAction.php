<?php

namespace application\modules\rest\controllers\Currency;

use application\modules\rest\controllers;
use application\modules\rest\models;

class GetAllAction extends controllers\DefaultAction
{
    /**
     * Returns action handler instance
     *
     * @return models\Handler|models\Currency\GetAll\Handler
     */
    public function handler(): models\Currency\GetAll\Handler
    {
        return new models\Currency\GetAll\Handler();
    }
}
