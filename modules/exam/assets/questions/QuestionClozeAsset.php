<?php
namespace modules\exam\assets\questions;
use yii\web\AssetBundle;

class  QuestionClozeAsset extends AssetBundle
{
    public $sourcePath = '@modules/exam/questions/dist';

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