<?php


namespace backend\assets;

use yii\web\AssetBundle;

class OlympicEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dist/olympic';
    public $js = [
         'js/edit.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}