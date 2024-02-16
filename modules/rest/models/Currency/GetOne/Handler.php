<?php

namespace application\modules\rest\models\Currency\GetOne;

use application\modules\rest\models;
use application\modules\rest\models\Entity;

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

        $response = new Response();
        $response->embedded = $this->request->embedded();
        $response->currency = Entity\Currency::find()->code($this->request->code())->one();

        return $response->prepare();
    }
}
