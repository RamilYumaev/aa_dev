<?php


namespace backend\assets;


use yii\web\AssetBundle;

class ModalAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/dist';
    public $js = [
         'js/modal.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}