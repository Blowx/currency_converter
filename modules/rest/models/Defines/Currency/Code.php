<?php

namespace application\modules\rest\models\Defines\Currency;

/**
 * Class Code.php
 **/
class Code
{
    const RUB = 'RUB';
    const AUD = 'AUD';
    const AZN = 'AZN';
    const GBP = 'GBP';
    const AMD = 'AMD';
    const BYN = 'BYN';
    const BGN = 'BGN';
    const BRL = 'BRL';
    const HUF = 'HUF';
    const VND = 'VND';
    const HKD = 'HKD';
    const GEL = 'GEL';
    const DKK = 'DKK';
    const AED = 'AED';
    const USD = 'USD';
    const EUR = 'EUR';
    const EGP = 'EGP';
    const INR = 'INR';
    const IDR = 'IDR';
    const KZT = 'KZT';
    const CAD = 'CAD';
    const QAR = 'QAR';
    const KGS = 'KGS';
    const CNY = 'CNY';
    const MDL = 'MDL';
    const NZD = 'NZD';
    const NOK = 'NOK';
    const PLN = 'PLN';
    const RON = 'RON';
    const XDR = 'XDR';
    const SGD = 'SGD';
    const TJS = 'TJS';
    const THB = 'THB';
    const TRY = 'TRY';
    const TMT = 'TMT';
    const UZS = 'UZS';
    const UAH = 'UAH';
    const CZK = 'CZK';
    const SEK = 'SEK';
    const CHF = 'CHF';
    const RSD = 'RSD';
    const ZAR = 'ZAR';
    const KRW = 'KRW';
    const JPY = 'JPY';

    public static function all()
    {
        return [
            self::RUB,
            self::AUD,
            self::AZN,
            self::GBP,
            self::AMD,
            self::BYN,
            self::BGN,
            self::BRL,
            self::HUF,
            self::VND,
            self::HKD,
            self::GEL,
            self::DKK,
            self::AED,
            self::USD,
            self::EUR,
            self::EGP,
            self::INR,
            self::IDR,
            self::KZT,
            self::CAD,
            self::QAR,
            self::KGS,
            self::CNY,
            self::MDL,
            self::NZD,
            self::NOK,
            self::PLN,
            self::RON,
            self::XDR,
            self::SGD,
            self::TJS,
            self::THB,
            self::TRY,
            self::TMT,
            self::UZS,
            self::UAH,
            self::CZK,
            self::SEK,
            self::CHF,
            self::RSD,
            self::ZAR,
            self::KRW,
            self::JPY,
        ];
    }

    public static function exists(string $code): bool
    {
        return in_array($code, Code::all());
    }

    public static function topPrio(): array
    {
        return [
            self::RUB,
            self::USD,
            self::EUR,
            self::CNY,
            self::GBP,
            self::CHF,
            self::KZT,
            self::JPY,
            self::BYN,
            self::PLN,
            self::TRY,
            self::AED,
        ];
    }

    public static function isTopPrio($code): bool
    {
        return in_array($code, self::topPrio());
    }
}
