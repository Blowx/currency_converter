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
     * @param $priority
     *
     * @return $this
     */
    public function priority($priority)
    {
        return $this->andWhere([
            Entity\Currency::tableName() . '.' . Defines\Request\Parameter::PRIORITY => $priority
        ]);
    }

    /**
     * @param $priority
     *
     * @return $this
     */
    public function notLowPriority()
    {
        return $this->andWhere([
            '!=',
            Entity\Currency::tableName() . '.' . Defines\Request\Parameter::PRIORITY,
            Defines\Currency\Priority::LOW_PRIO
        ]);
    }

    /**
     * @return $this
     */
    public function orderByPriority()
    {
        return $this->addOrderBy( Defines\Request\Parameter::PRIORITY . ' DESC');
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
