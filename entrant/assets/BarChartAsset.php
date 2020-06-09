<?php


namespace entrant\assets;


use yii\web\AssetBundle;

class BarChartAsset extends AssetBundle
{
    public $sourcePath = '@entrant/assets/charts';
    public $js = [
        'bar.js'
        // more plugin Js here
    ];
    public $depends = [
        ChartAsset::class,
    ];

}