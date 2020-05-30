<?php

namespace common\auth\actions\assets;
use yii\web\AssetBundle;

class EntrantAsset extends AssetBundle
{
    public $sourcePath = '@common/auth/actions/assets/dist/entrant';
    public $js = [
        'js/profile.js',
        'css/style.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
