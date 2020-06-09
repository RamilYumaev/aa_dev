<?php


namespace entrant\assets;


use yii\web\AssetBundle;

class ChartAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/';
    public $js = [
        'bower_components/chart.js/Chart.js',
        'bower_components/fastclick/lib/fastclick.js'
        // more plugin Js here
    ];
//    public $depends = [
//        'dmstr\web\AdminLteAsset',
//    ];

}