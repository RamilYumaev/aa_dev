<?php
namespace modules\exam\assets\questions;
use yii\web\AssetBundle;

class QuestionSelectTypeAsset extends AssetBundle
{
    public $sourcePath = '@modules/exam/assets/questions/dist';

    public $js = [
        'js/question-select-type.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}