<?php

namespace common\fixtures\olympic;

use olympic\models\OlimpiadsTypeTemplates;
use yii\test\ActiveFixture;

class OlimpiadsTypeTemplatesFixture extends ActiveFixture
{
    public $modelClass = OlimpiadsTypeTemplates::class;
    public $depends = OlympicFixture::class;
}