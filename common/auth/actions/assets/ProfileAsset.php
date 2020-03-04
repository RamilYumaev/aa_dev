<?php

namespace common\auth\actions\assets;
use yii\web\AssetBundle;

class ProfileAsset extends AssetBundle
{
    public $sourcePath = '@common/auth/actions/assets/dist/profile';
    public $js = [
        'js/profile.js',
        'css/style.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
