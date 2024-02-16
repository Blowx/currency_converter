<?php

namespace application\modules\rest\models;

use application\models as CoreModels;

/**
 * Class Instance
 *
 * @package application\modules\rest\models
 * @inheritdoc
 */
class Instance extends CoreModels\Instance
{
    /**
     * Returns configuration model instance
     *
     * @return Config
     */
    public static function config()
    {
        return self::get(Config::class);
    }
}
