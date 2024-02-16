<?php

namespace application\modules\rest\controllers;

use yii;

class CurrencyController extends yii\rest\Controller
{

    /**
     * @inheritdoc
     * @return array
     */
    public function actions()
    {
        return [
            'get-one' => 'application\modules\rest\controllers\Currency\GetOneAction',
            'get-all' => 'application\modules\rest\controllers\Currency\GetAllAction',
            'exchange-get-all' => 'application\modules\rest\controllers\Currency\Exchange\GetAllAction',
        ];
    }
}
