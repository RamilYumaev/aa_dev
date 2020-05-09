<?php
namespace modules\entrant\assets\passport;
use yii\web\AssetBundle;

class PassportAsset extends AssetBundle
{
    public $sourcePath = '@modules/entrant/assets/passport/dist';

    public $js = [
        'js/passport.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

    public $publishOptions = [
        'forceCopy'=>true,
    ];
}