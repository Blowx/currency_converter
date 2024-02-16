<?php

namespace application\modules\rest\models\Entity;

use application\modules\rest\models\Defines;
use application\modules\rest\models\MySqlEntity;

class Configuration extends MySqlEntity
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Defines\Entity\Table::CONFIGURATION;
    }
}
