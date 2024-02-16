<?php

namespace application\modules\web\assets;

use yii\web\AssetBundle;

/**
 * Class WebAsset.php
 **/
class WebAsset extends AssetBundle
{
    public $sourcePath = '@application/modules/web/assets';

    public $css = [
        'css/style.css',
        'css/style2.css',
        'css/style3.css',
    ];

    public $js = [
        'js/converter.js',
    ];

    public $cssOptions = [
        'rel' => 'stylesheet',
    ];
}
