<?php

namespace application\modules\rest\models\Currency\GetOne;

use application\modules\rest\models;
use application\modules\rest\models\Action;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Request extends models\Request
{
    /**
     * @inheritdoc
     */
    public function required(): array
    {
        $data = parent::required();

        return array_merge($data, [Defines\Request\Parameter::CODE]);
    }

    public function code()
    {
        return $this->getStr(Defines\Request\Parameter::CODE);
    }

    /**
     * @inheritdoc
     */
    public function validate(): bool
    {
        parent::validate();
        $currencyExists = Entity\Currency::find()->code($this->code())->exists();

        if (!$currencyExists) {
            throw new Action\Error\NotFound(Defines\Api\Error::CURRENCY_NOT_FOUND);
        }

        return true;
    }
}
