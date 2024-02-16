<?php

namespace application\modules\rest\models\Entity\Currency;

use application\models\Defines as modelsDefines;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

/**
 * Class Factory.php
 **/
class Factory
{
    public static function createFromDto($currencyDTO): Entity\Currency
    {
        $currency = new Entity\Currency();
        $currency->numCode = $currencyDTO->numCode;
        $currency->name = $currencyDTO->name;
        $currency->source = modelsDefines\Parser\Source::CBR_RU;
        $currency->status = Defines\Status::ACTIVE;
        $currency->code = $currencyDTO->code;
        $currency->priority = Defines\Currency\Code::isTopPrio($currencyDTO->code) ?
            Defines\Currency\Priority::getByCode($currencyDTO->code) : Defines\Currency\Priority::LOW_PRIO;

        return $currency;
    }
}
