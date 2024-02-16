<?php

namespace application\modules\rest\models;

use yii;
use application\modules\core;
use application\modules\rest\models\Defines;

/**
 * Class Request
 *
 * @package application\modules\rest\models
 * @property string $target
 * @property array  $params
 * @property array  $allowFilterParams
 * @property bool   $strNull
 */
class Request extends core\models\Request
{
    /**
     * @inheritDoc
     */
    public function validateRequired(): bool
    {
        $result = parent::validateRequired();
        if (true !== $result) {
            $data = core\models\Request\Helper::implode($result, false);
            throw new Action\Error\BadRequest(Defines\Api\Error::PARAM_NOT_FOUND, $data);
        }
        return true;
    }
}
