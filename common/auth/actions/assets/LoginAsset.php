<?php
namespace common\auth\actions\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $sourcePath = '@common/auth/actions/assets/dist/login';
    public $css = [
        'css/login_form.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}