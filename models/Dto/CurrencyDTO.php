<?php

namespace application\models\Dto;

/**
 * @property int    $numCode
 * @property string $code
 * @property string $name
 * @property int    $nominal
 * @property float  $value
 * @property float  $vUnitRate
 */
class CurrencyDTO
{
    public function __construct(
        public ?string $numCode = null,
        public ?string $code = null,
        public ?int $nominal = null,
        public ?string $name = null,
        public ?float $value = null,
        public ?float $vUnitRate = null
    ) {
    }
}
