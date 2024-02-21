<?php

namespace application\modules\rest\models\Currency\Exchange\GetAll;

/**
 * Class Request
 **/

use application\modules\rest\models;
use application\modules\rest\models\Action;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Request extends models\Request\Search
{
    /**
     * @inheritdoc
     */
    public function required(): array
    {
        $data = parent::required();

        return array_merge($data, [Defines\Request\Parameter::CODE, Defines\Request\Parameter::AMOUNT]);
    }

    /**
     * Code
     *
     * @return mixed|string
     */
    public function code()
    {
        return $this->getStr(Defines\Request\Parameter::CODE);
    }

    /**
     * Amount
     *
     * @return float
     */
    public function amount()
    {
        return $this->getFlt(Defines\Request\Parameter::AMOUNT);
    }

    /**
     * @inheritdoc
     */
    public function validate(): bool
    {
        parent::validate();
        $currencyExists = Entity\Currency::find()->code($this->code())->exists();

        match (true) {
            !$currencyExists => throw new Action\Error\NotFound(Defines\Api\Error::CURRENCY_NOT_FOUND),
            $this->amount() < 0 => throw new Action\Error\BadRequest(Defines\Api\Error::INVALID_AMOUNT),
            default => '',
        };

        return true;
    }
}
