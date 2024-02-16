<?php

namespace application\modules\rest\models\Defines\Currency;

use application\modules\rest\models\Defines;
/**
 * Class Priority.php
 **/
class Priority
{
    const RUB_PRIO = 99;

    const USD_PRIO = 98;

    const EUR_PRIO = 97;

    const CNY_PRIO = 96;

    const GBP_PRIO = 95;

    const CHF_PRIO = 94;

    const KZT_PRIO = 93;

    const JPY_PRIO = 92;

    const BYN_PRIO = 91;

    const PLN_PRIO = 90;

    const TRY_PRIO = 89;

    const AED_PRIO = 88;

    const LOW_PRIO = 1;

    public static function mapping()
    {
        return [
            Defines\Currency\Code::RUB => Priority::RUB_PRIO,
            Defines\Currency\Code::USD => Priority::USD_PRIO,
            Defines\Currency\Code::EUR => Priority::EUR_PRIO,
            Defines\Currency\Code::CNY => Priority::CNY_PRIO,
            Defines\Currency\Code::GBP => Priority::GBP_PRIO,
            Defines\Currency\Code::CHF => Priority::CHF_PRIO,
            Defines\Currency\Code::KZT => Priority::KZT_PRIO,
            Defines\Currency\Code::JPY => Priority::JPY_PRIO,
            Defines\Currency\Code::BYN => Priority::BYN_PRIO,
            Defines\Currency\Code::PLN => Priority::PLN_PRIO,
            Defines\Currency\Code::TRY => Priority::TRY_PRIO,
            Defines\Currency\Code::AED => Priority::AED_PRIO,
        ];
    }

    public static function getByCode(string $code): int
    {
        $mappedArray = self::mapping();

        if (isset($mappedArray[$code])) {
            return $mappedArray[$code];
        }

        return self::LOW_PRIO;
    }
}
