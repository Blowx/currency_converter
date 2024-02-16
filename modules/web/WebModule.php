<?php
namespace application\modules\web;

use application\modules\web\assets\WebAsset;
use yii;

class WebModule extends yii\base\Module
{
    public function init()
    {
        parent::init();
        WebAsset::register(Yii::$app->view);
    }
}
