<?php

namespace common\fixtures\dictionary;

use dictionary\models\DictSpecialization;
use yii\test\ActiveFixture;

class DictSpecializationFixture extends ActiveFixture
{
    public $modelClass = DictSpecialization::class;
    public $depends = DictSpecialityFixture::class;
}