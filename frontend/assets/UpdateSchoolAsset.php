<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class UpdateSchoolAsset extends AssetBundle
{
    public $sourcePath = '@frontend/assets/dist/school';
    public $js = [
        'js/update-user-school.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
