<?php

namespace common\fixtures\testing;

use testing\models\TestClass;
use yii\test\ActiveFixture;

class TestClassFixture extends ActiveFixture
{
    public $modelClass = TestClass::class;
}