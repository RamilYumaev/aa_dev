<?php


namespace backend\assets;


use yii\web\AssetBundle;

class OlympicCreateAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dist/olympic';
    public $js = [
         'js/create.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}