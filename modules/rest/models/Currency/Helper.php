<?php
namespace application\modules\rest\models\Currency;

use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Helper
{
    /**
     * Returns currency's data
     *
     * @param Entity\Currency $currency
     * @param array           $embedded
     *
     * @return array
     */
    public static function getData(Entity\Currency $currency, array $embedded = []): array
    {
        $data = self::getDefaultData($currency);

        foreach ($embedded as $e) {
            switch ($e) {
                case Defines\Currency\Embedded::AMOUNT:
                    $data = array_merge($data, self::getValueData($currency));
                    break;
            }
        }

        return $data;
    }

    /**
     * Returns base currency's data
     *
     * @param Entity\Currency $currency
     *
     * @return array
     */
    public static function getDefaultData(Entity\Currency $currency)
    {
        return [
            'id' => $currency->id,
            'name' => $currency->name,
            'code' => $currency->code,
            'numCode' => $currency->numCode,
        ];
    }

    /**
     * Returns information about latest currency's exchange value
     *
     * @param Entity\Currency $currency
     *
     * @return array
     */
    public static function getValueData(Entity\Currency $currency)
    {
        $lastState = $currency->lastCurrencyState;

        return [
            'value' => $lastState->value,
            'vUnitRate' => $lastState->vUnitRate,
            'nominal' => $lastState->nominal,
        ];
    }
}
