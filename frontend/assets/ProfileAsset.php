<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class ProfileAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist/auth';
    public $js = [
        'js/profile.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
