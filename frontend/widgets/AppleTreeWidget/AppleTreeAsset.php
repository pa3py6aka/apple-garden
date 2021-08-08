<?php

namespace frontend\widgets\AppleTreeWidget;

use frontend\assets\AppAsset;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppleTreeAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/AppleTreeWidget';

    public $css = [
        'css/tree.css',
    ];

    public $js = [
    ];

    public $depends = [
        AppAsset::class,
    ];
}
