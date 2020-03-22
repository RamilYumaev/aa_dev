<?php
namespace modules\entrant\assets\cse;
use yii\web\AssetBundle;

class  CseSubjectResultAsset extends AssetBundle
{
    public $sourcePath = '@modules/entrant/assets/cse/dist';

    public $js = [
        'js/cse-subject-result.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}