<?php

namespace backend\assets\dod;

use yii\web\AssetBundle;

class DodCreateAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dod/dist';
    public $js = [
         'js/create.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}