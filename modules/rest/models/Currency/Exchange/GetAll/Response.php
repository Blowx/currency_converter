<?php

namespace application\modules\rest\models\Currency\Exchange\GetAll;

/**
 * Class Response
 **/

use application\modules\rest\models;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Response extends models\Response
{
    /**
     * @var ?Entity\Currency $requestedCurrency
     */
    public ?Entity\Currency $requestedCurrency = null;
    /**
     * @var Entity\Currency[] $currencies
     */
    public array $currencies = [];

    /**
     * Embedded array
     *
     * @var array
     */
    public array $embedded = [];
    /**
     * Count of currencies
     *
     * @var int
     */
    public int $count = 0;
    /**
     * Amount of currency
     */
    public ?float $amount = 0;
    /**
     * Query config params
     *
     * @var QueryConfig|null $config
     */
    public ?QueryConfig $config = null;

    /**
     * @inheritdoc
     */
    public function prepare(): array
    {
        $this->data = [];

        foreach ($this->currencies as $currency) {

            $this->data[] = models\Currency\Exchange\Helper::getData($currency, $this->requestedCurrency,
                $this->amount);
        }

        return [
            'count' => $this->count,
            'items' => $this->data,
            'offset' => $this->config->offset,
            'pageSize' => (!is_null($this->config->limit)) ? $this->config->limit : Defines\Config::DEFAULT_DATA_LIMIT,
        ];
    }
}
