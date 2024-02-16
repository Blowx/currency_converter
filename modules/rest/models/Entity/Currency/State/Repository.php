<?php

namespace application\modules\rest\models\Entity\Currency\State;

use application\modules\rest\models\Entity;

/**
 * Class Repository.php
 **/
class Repository
{
    public static function findTodayByCurrencyId($currencyId, string $date): ?Entity\Currency\State
    {
        return Entity\Currency\State::find()
            ->where(['AND', ['currencyId' => $currencyId], ['=', 'DATE_FORMAT(date, "%Y-%m-%d")', $date]])
            ->one();
    }
}
