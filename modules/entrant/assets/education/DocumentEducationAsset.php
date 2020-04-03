<?php
namespace modules\entrant\assets\education;
use yii\web\AssetBundle;

class DocumentEducationAsset extends AssetBundle
{
    public $sourcePath = '@modules/entrant/assets/education/dist';

    public $js = [
        'js/document-education.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}