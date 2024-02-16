<?php

/**
 * Class implementing Configuration functionality
 *
 * @property integer $id
 * @property string  $name
 * @property string  $type
 * @property string  $value
 */

namespace application\models\entities;

class Configuration extends DBEntity
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuration';
    }
}
