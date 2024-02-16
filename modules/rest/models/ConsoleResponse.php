<?php

namespace application\modules\rest\models;

use yii\web\HeaderCollection;

/**
 * Class ConsoleResponse
 *
 * @package application\modules\rest\models
 * @property HeaderCollection $headers The header collection. This property is read-only.
 */
class ConsoleResponse extends \yii\console\Response
{
    public $headers;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->headers = new HeaderCollection();
    }
}
