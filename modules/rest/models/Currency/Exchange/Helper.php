<?php

namespace application\modules\rest\models\Currency\Exchange;

use application\modules\rest\models\Entity;

/**
 * Class Helper.php
 **/
class Helper
{
    public static function getData(Entity\Currency $currency, Entity\Currency $requestedCurrency, $amount): array
    {
        return [
            'id' => $currency->id,
            'code' => $currency->code,
            'name' => $currency->name,
            'amount' => Helper::calculateValue(
                $currency->lastCurrencyState,
                $requestedCurrency->lastCurrencyState,
                $amount)
        ];
    }

    public static function calculateValue(
        Entity\Currency\State $currencyState,
        Entity\Currency\State $requestedCurrencyState,
        float $amount
    ): float {
        return round($amount * $requestedCurrencyState->vUnitRate * $requestedCurrencyState->nominal /
            ($currencyState->vUnitRate * $currencyState->nominal), 4);
    }
}
