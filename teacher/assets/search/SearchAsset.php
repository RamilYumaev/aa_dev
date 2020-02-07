<?php

namespace teacher\assets\search;

use yii\web\AssetBundle;

class SearchAsset extends AssetBundle
{
    public $sourcePath = '@teacher/assets/search/dist';
    public $js = [
         'js/change-form.js',
    ];


    public $depends = [
        'yii\web\YiiAsset',
    ];

}