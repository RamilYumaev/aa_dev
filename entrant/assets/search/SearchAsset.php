<?php

namespace entrant\assets\search;

use yii\web\AssetBundle;

class SearchAsset extends AssetBundle
{
    public $sourcePath = '@entrant/assets/search/dist';
    public $js = [
         'js/change-form.js',
    ];


    public $depends = [
        'yii\web\YiiAsset',
    ];

}