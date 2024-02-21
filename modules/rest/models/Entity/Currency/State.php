<?php

namespace application\modules\rest\models\Entity\Currency;

use application\modules\rest\models;
use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

/**
 * @property int             $id
 * @property int             $currencyId
 * @property int             $createdAt
 * @property int             $updatedAt
 * @property int             $date
 * @property int             $nominal
 * @property float           $value
 * @property float           $vUnitRate
 * @property Entity\Currency $currency
 */
class State extends models\MySqlEntity
{
    public static function tableName()
    {
        return Defines\Entity\Table::CURRENCY_STATE;
    }

    public function rules()
    {
        return [
            [['currencyId', 'nominal'], 'integer'],
            [['createdAt', 'updatedAt', 'date'], 'safe'],
            [['value', 'vUnitRate'], 'number'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Entity\Currency::class, ['id' => 'currencyId']);
    }
}
