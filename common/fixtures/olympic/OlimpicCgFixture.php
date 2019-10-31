<?php

namespace common\fixtures\olympic;

use olympic\models\OlimpicCg;
use yii\test\ActiveFixture;

class OlimpicCgFixture extends ActiveFixture
{
    public $modelClass = OlimpicCg::class;
    public $depends = [OlympicFixture::class, DictCompetitiveGroupFixture::class];
}