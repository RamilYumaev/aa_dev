<?php
namespace backend\assets\questions;
use yii\web\AssetBundle;

class  QuestionClozeAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/questions/dist';

    public $js = [
        'js/question-cloze.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}