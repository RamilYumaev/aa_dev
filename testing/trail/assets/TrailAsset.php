<?php

namespace testing\trail\assets;

use yii\web\AssetBundle;

class TrailAsset extends AssetBundle
{
    public $sourcePath = '@frontend/web';
    public $css = [
        'css/site.css',
        'css/front_page.css',
    ];
    public $js = [
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
