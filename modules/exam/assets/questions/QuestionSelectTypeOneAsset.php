<?php
namespace modules\exam\assets\questions;
use yii\web\AssetBundle;

class QuestionSelectTypeOneAsset extends AssetBundle
{
    public $sourcePath = '@modules/exam/assets/questions/dist';

    public $js = [
        'js/question-select-type-one.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}