<?php

namespace common\fixtures\olympic;

use olympic\models\OlimpicNomination;
use yii\test\ActiveFixture;

class OlimpicNominationFixture extends ActiveFixture
{
    public $modelClass = OlimpicNomination::class;
    public $depends = OlympicFixture::class;
}