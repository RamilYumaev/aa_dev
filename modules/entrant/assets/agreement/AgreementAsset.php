<?php
namespace modules\entrant\assets\agreement;
use yii\web\AssetBundle;

class  AgreementAsset extends AssetBundle
{
    public $sourcePath = '@modules/entrant/assets/agreement/dist';

    public $js = [
        'js/agreement.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}