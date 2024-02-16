<?php

namespace application\models\entities;

use application\models\query\ActiveQuery;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * Class implementing default Database Entity functionality
 *
 * @property boolean $saveLog
 */
class DBEntity extends ActiveRecord
{
    // Default table name to store data into
    protected static $sTableName = null;

    public function init()
    {
        $this->loadDefaultValues();
        parent::init();
    }

    /**
     * @return object|\yii\db\ActiveQuery
     * @throws InvalidConfigException
     */
    public static function find()
    {
        return \Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * @return object|\yii\db\ActiveQuery
     * @throws InvalidConfigException
     */
    public static function model()
    {
        return self::find();
    }

    public static function tableName()
    {
        return static::$sTableName;
    }

    /**
     * Returns attribute values.
     *
     * @param array $names  list of attributes whose value needs to be returned.
     *                      Defaults to null, meaning all attributes listed in [[attributes()]] will be returned.
     *                      If it is an array, only the attributes in the array will be returned.
     * @param array $except list of attributes whose value should NOT be returned.
     *
     * @return array attribute values (name => value).
     */
    public function getAttributes($names = null, $except = [])
    {
        $values = [];
        if ($names === null) {
            $names = $this->attributes();
        }
        foreach ($names as $name) {
            if ($this->hasAttribute($name)) {
                $values[ $name ] = $this->$name;
            } else {
                $values[ $name ] = null;
            }
        }
        foreach ($except as $name) {
            unset($values[ $name ]);
        }

        return $values;
    }
}
