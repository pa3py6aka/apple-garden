<?php

namespace backend\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;

class AppleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/apples.js'
    ];

    public $depends = [
        AppAsset::class,
        BootstrapPluginAsset::class,
    ];
}
