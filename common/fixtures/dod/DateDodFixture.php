<?php

namespace common\fixtures\dictionary;

use common\fixtures\UserFixture;
use dod\models\DateDod;
use yii\test\ActiveFixture;

class DateDodFixture extends ActiveFixture
{
    public $modelClass = DateDod::class;
    public $depends = DodFixture::class;
}