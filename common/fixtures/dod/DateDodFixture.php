<?php

namespace common\fixtures\dictionary;

use common\fixtures\UserFixture;
use olympic\models\UserOlimpiads;
use yii\test\ActiveFixture;

class UserOlimpiadsFixture extends ActiveFixture
{
    public $modelClass = UserOlimpiads::class;
    public $depends = [UserFixture::class, OlympicFixture::class];
}