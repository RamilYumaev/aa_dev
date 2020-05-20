<?php


namespace backend\assets\modal;


use yii\web\AssetBundle;

class ModalPjaxAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/modal/dist';
    public $js = [
         'js/modal-pjax.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}