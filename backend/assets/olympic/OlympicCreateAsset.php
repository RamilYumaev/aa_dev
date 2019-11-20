<?php

namespace backend\assets\olympic;

use yii\web\AssetBundle;

class OlympicCreateAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/olympic/dist';
    public $js = [
         'js/create.js',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}