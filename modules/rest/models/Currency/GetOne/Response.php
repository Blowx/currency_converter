<?php

namespace application\modules\rest\models\Currency\GetOne;

use application\modules\rest\models;
use application\modules\rest\models\Entity;

class Response extends models\Response
{
    public ?Entity\Currency $currency = null;


    /**
     * Embedded array
     *
     * @var array
     */
    public array $embedded = [];

    /**
     * @inheritdoc
     */
    public function prepare(): array
    {
        return models\Currency\Helper::getData($this->currency, $this->embedded);
    }
}
