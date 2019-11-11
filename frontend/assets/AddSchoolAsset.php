<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class AddSchoolAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist/school';
    public $js = [
        'js/add-user-school.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
