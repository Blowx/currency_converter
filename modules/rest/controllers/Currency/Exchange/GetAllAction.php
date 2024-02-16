<?php

namespace application\modules\rest\controllers\Currency\Exchange;


use application\modules\rest\controllers;
use application\modules\rest\models;

class GetAllAction extends controllers\DefaultAction
{
    /**
     * Returns action handler instance
     *
     * @return models\Handler|models\Currency\Exchange\GetAll\Handler
     */
    public function handler(): models\Currency\Exchange\GetAll\Handler
    {
        return new models\Currency\Exchange\GetAll\Handler();
    }
}
