<?php
namespace backend\assets\questions;
use yii\web\AssetBundle;

class  QuestionAnswerShortAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/questions/dist';

    public $js = [
        'js/question-answer-short.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}