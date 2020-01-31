<?php
namespace backend\assets\questions;
use yii\web\AssetBundle;

class QuestionSelectTypeAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/questions/dist';

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