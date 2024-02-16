<?php

namespace application\modules\rest\models\Entity;

use application\models\entities\DBEntity as BaseDBEntity;
use yii\base\InvalidConfigException;

class DBEntity extends BaseDBEntity
{
    /**
     * @return object|\yii\db\ActiveQuery
     * @throws InvalidConfigException
     */
    public static function find(): ActiveQuery
    {
        return \Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }
}
