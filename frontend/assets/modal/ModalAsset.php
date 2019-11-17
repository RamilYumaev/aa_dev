<?php


namespace frontend\assets\modal;


use yii\web\AssetBundle;

class ModalAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/modal/dist';
    public $js = [
         'js/modal.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}