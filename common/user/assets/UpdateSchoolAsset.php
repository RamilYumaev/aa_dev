<?php

namespace common\user\assets;

use yii\web\AssetBundle;


class UpdateSchoolAsset extends AssetBundle
{
    public $sourcePath = '@common/user/assets/dist/school';
    public $js = [
        'js/update-user-school.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
