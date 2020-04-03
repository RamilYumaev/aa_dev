<?php
namespace modules\entrant\assets\other;
use yii\web\AssetBundle;

class OtherDocumentAsset extends AssetBundle
{
    public $sourcePath = '@modules/entrant/assets/other/dist';

    public $js = [
        'js/document-other.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}