<?php


namespace backend\assets\dod;

use yii\web\AssetBundle;

class DodEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dod/dist';
    public $js = [
         'js/edit.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}