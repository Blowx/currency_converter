<?php

namespace application\modules\rest\models\Currency\GetAll;

use application\modules\rest\models;
use application\modules\rest\models\Defines;

class Request extends models\Request\Search
{
    public $allowFilterParams = [Defines\Request\Parameter::STATUS];
}
