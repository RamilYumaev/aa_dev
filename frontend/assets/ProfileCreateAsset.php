<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class ProfileCreateAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist/auth';
    public $js = [
        'js/profile-create.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
