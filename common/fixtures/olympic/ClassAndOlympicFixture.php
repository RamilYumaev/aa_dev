<?php

namespace common\fixtures\olympic;

use olympic\models\ClassAndOlympic;
use yii\test\ActiveFixture;
use common\fixtures\dictionary\DictClassFixture;

class ClassAndOlympicFixture extends ActiveFixture
{
    public $modelClass = ClassAndOlympic::class;
    public $depends = [
        OlympicFixture::class,
        DictClassFixture::class,
    ];
}