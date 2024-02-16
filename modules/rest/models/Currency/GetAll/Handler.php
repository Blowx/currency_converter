<?php

namespace application\modules\rest\models\Currency\GetAll;

use application\modules\rest\models;
use application\modules\rest\models\Entity;

/**
 * @property Request $request
 */
class Handler extends models\Handler
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->request = new Request();
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        parent::process();

        $config = new QueryConfig();
        $config->assignRequestData($this->request);
        $query = Entity\Currency\Repository::query($config);
        $response = new Response();
        $response->currencies = $query->all();
        $response->count = $query->count();
        $response->config = $config;
        $response->embedded = $this->request->embedded();

        return $response->prepare();
    }
}
