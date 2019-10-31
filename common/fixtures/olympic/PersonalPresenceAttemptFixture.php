<?php

namespace common\fixtures\olympic;

use olympic\models\PersonalPresenceAttempt;
use yii\test\ActiveFixture;

class PersonalPresenceAttemptFixture extends ActiveFixture
{
    public $modelClass = PersonalPresenceAttempt::class;
    public $depends = OlympicFixture::class;
}