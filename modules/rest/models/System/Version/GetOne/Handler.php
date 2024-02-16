<?php

namespace application\modules\rest\models\System\Version\GetOne;

use application\modules\rest\models;

/**
 * Class Handler
 *
 * @package application\modules\rest\models\System\Version\GetOne
 */
class Handler extends models\Handler
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->request = new Request();
        static::$authorized = true;
    }

    /**
     * @inheritdoc
     */
    public function authorize()
    {
        static::$permitted = true;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        parent::process();

        $response = new Response();

        return $response->prepare();
    }

}
