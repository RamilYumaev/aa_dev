<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class CountdownAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist/countdown';
    public $js = [
        'countdown.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}

