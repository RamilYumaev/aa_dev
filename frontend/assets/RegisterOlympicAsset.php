<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class RegisterOlympicAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist/olympic';
    public $js = [
        'js/register-user-olympic.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
