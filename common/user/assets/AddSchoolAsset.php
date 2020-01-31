<?php

namespace common\user\assets;

use yii\web\AssetBundle;


class AddSchoolAsset extends AssetBundle
{
    public $sourcePath = '@common/user/assets/dist/school';
    public $js = [
        'js/add-user-school.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
