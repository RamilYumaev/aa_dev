<?php

namespace common\fixtures\olympic;

use olympic\models\Diploma;
use yii\test\ActiveFixture;

class DiplomaFixture extends ActiveFixture
{
    public $modelClass = Diploma::class;
    public $depends = OlympicFixture::class;
}