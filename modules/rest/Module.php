<?php
namespace application\modules\rest;

use yii;

class Module extends yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setVersion(models\Defines\Api\Version::CURRENT);
        parent::init();
    }
}
