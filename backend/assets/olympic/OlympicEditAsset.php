<?php


namespace backend\assets\olympic;

use yii\web\AssetBundle;

class OlympicEditAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/olympic/dist';
    public $js = [
         'js/edit.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];

}