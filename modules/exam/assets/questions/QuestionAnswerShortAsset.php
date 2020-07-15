<?php
namespace modules\exam\assets\questions;
use yii\web\AssetBundle;

class QuestionAnswerShortAsset extends AssetBundle
{
    public $sourcePath = '@modules/exam/assets/questions/dist';

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