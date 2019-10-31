<?php

namespace common\fixtures\testing;

use testing\models\Test;
use yii\test\ActiveFixture;

class TestFixture extends ActiveFixture
{
    public $modelClass = Test::class;
}