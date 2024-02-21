<?php

namespace application\modules\rest\models\Entity;

use application\modules\rest\models;
use application\modules\rest\models\Defines;

/**
 * @property int     $id
 * @property string  $numCode
 * @property string  $name
 * @property string  $source
 * @property int     $createdAt
 * @property int     $updatedAt
 * @property int     $status
 * @property string  $code
 * @property int     $priority
 * @property Currency\State[] $currencyStates
 * @property Currency\State   $lastCurrencyState
 */
class Currency extends models\MySqlEntity
{
    public static function tableName()
    {
        return Defines\Entity\Table::CURRENCY;
    }

    /**
     * @inheritdoc
     */
    public static function find(): ActiveQuery
    {
        return new Currency\Query( get_called_class() );
    }

    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name', 'source', 'code', 'numCode'], 'string', 'max' => 255],
            [['createdAt', 'updatedAt', 'priority'], 'safe'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyStates()
    {
        return $this->hasMany(Currency\State::class, ['currencyId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastCurrencyState()
    {
        return $this->hasOne(Currency\State::class, ['currencyId' => 'id'])
            ->orderBy(['date' => SORT_DESC])
            ->limit(1);
    }
}
