<?php

namespace application\modules\web\controllers;

/**
 * Class ConverterController.php
 **/

use yii\web\Controller;
use application\modules\rest\models as RestModels;
use application\modules\rest\models\Defines as RestDefines;
use application\modules\rest\models\Entity as RestEntity;
use application\modules\rest\models\Instance as RestInstance;

class ConverterController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'main';
        $defaultCurrency = RestEntity\Currency::find()->code(RestInstance::config()->get('DEFAULT_CURRENCY_CODE'))->one();
        $currencies = RestEntity\Currency::find()->status(RestDefines\Status::ACTIVE)->all();

        $currencyData = [];

        foreach ($currencies as $currency) {
            $currencyData[] = restModels\Currency\Exchange\Helper::getData($currency, $defaultCurrency, 100);
        }

        return $this->render('index', [
            'currencies' => $currencyData
        ]);
    }
}
