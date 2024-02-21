<?php

namespace application\modules\rest\models\Entity\Currency;

use application\modules\rest\models\Defines;
use application\modules\rest\models\Entity;

class Repository
{
    /**
     * General query, that should be used in GET All endpoint
     *
     * @param Entity\QueryConfig $config
     *
     * @return Entity\ActiveQuery|object|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function query(Entity\QueryConfig $config)
    {
        $query = Entity\Currency::find()
            ->offset($config->offset)
            ->limit($config->limit);

        foreach ($config->filter as $key => $value) {
            switch ($key) {
                case Defines\Request\Parameter::STATUS:
                    $query->status($value);
                    break;
                // more filtrations, if needed
            }
        }
        if ($config->search) {
            $query->nameLike($config->search);
        }
        if ($config->sort) {
            switch ($config->sort) {
                case Defines\Request\Parameter::ID:
                case Defines\Request\Parameter::NAME:
                case Defines\Request\Parameter::CODE:
                case Defines\Request\Parameter::CREATED_AT:
                case Defines\Request\Parameter::UPDATED_AT:
                    $query->addOrderBy($config->sort . " " . $config->sortOrder);
                    break;
            }
        }

        $query->andFilterWhere(['NOT IN', 'LOWER(code)', $config->except]);

        return $query;
    }

    /**
     * Returns currency by it's charCode (AED\BYN\USD)
     *
     * @param string $code
     *
     * @return Entity\Currency|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByCode(string $code): ?Entity\Currency
    {
        return Entity\Currency::find()->code($code)->one();
    }

}
