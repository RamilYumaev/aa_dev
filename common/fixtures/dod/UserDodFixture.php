<?php

namespace common\fixtures\dod;

use common\fixtures\dictionary\DodFixture;
use common\fixtures\UserFixture;
use dod\models\UserDod;
use yii\test\ActiveFixture;

class UserDodFixture extends ActiveFixture
{
    public $modelClass = UserDod::class;
    public $depends = [UserFixture::class, DodFixture::class];
}