<?php

namespace application\modules\rest\models\Currency\GetAll;

use application\modules\rest\models;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Response extends models\Response
{
    /**
     * @var Entity\Currency[] $currencies
     */
    public array $currencies = [];

    public array $embedded = [];
    /**
     * Count of currencies
     *
     * @var int
     */
    public int $count = 0;
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

        foreach ($this->currencies as $c) {
            $this->data[] = models\Currency\Helper::getData($c, $this->embedded);
        }

        return [
            'count' => $this->count,
            'items' => $this->data,
            'offset' => $this->config->offset,
            'pageSize' => (!is_null($this->config->limit)) ? $this->config->limit : Defines\Config::DEFAULT_DATA_LIMIT,
        ];
    }
}
