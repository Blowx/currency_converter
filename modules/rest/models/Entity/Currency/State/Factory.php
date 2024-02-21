<?php

namespace application\modules\rest\models\Entity\Currency\State;

use application\modules\rest\models;
use application\modules\rest\models\Entity;
/**
 * Class Factory.php
 **/
class Factory
{
    /**
     * Returns currency state entity
     *
     * @param Entity\Currency $currency
     * @param                 $currencyDTO
     * @param string          $date
     *
     * @return Entity\Currency\State
     */
    public static function createFromDto(Entity\Currency $currency, $currencyDTO, string $date): Entity\Currency\State
    {
        $todayCurrency = new Entity\Currency\State();
        $todayCurrency->currencyId = $currency->id;
        $todayCurrency->date = $date;
        $todayCurrency->nominal = $currencyDTO->nominal;

        return $todayCurrency;
    }
}
