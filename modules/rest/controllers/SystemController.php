<?php

namespace application\modules\rest\controllers;

use yii;

class SystemController extends yii\rest\Controller
{
    /**
     * @inheritdoc
     * @return array
     */
    public function actions()
    {
        return [
            'version-get-one' => 'application\modules\rest\controllers\System\Version\GetOneAction',
        ];
    }
}
