<?php

namespace common\fixtures;


use olympic\models\auth\Profiles;
use yii\test\ActiveFixture;

class ProfileFixture extends ActiveFixture
{
    public $modelClass = Profiles::class;
   public $depends = [UserFixture::class];
}