<?php

namespace application\modules\rest\models\Entity\Currency;

use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Query extends Entity\ActiveQuery
{

    /**
     * @param $status
     *
     * @return $this
     */
    public function status($status)
    {
        return $this->andWhere([
            Entity\Currency::tableName() . '.' . Defines\Request\Parameter::STATUS => $status
        ]);
    }
    /**
     * @param $status
     *
     * @return $this
     */
    public function nameLike($name)
    {
        return $this->andWhere(['like', Entity\Currency::tableName() . '.' . Defines\Request\Parameter::NAME, $name]);
    }

    /**
     * @param $code
     *
     * @return $this
     */
    public function code($code)
    {
        return $this->andWhere([
            Entity\Currency::tableName() . '.' . Defines\Request\Parameter::CODE => $code
        ]);
    }
}
