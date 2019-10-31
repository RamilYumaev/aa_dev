<?php

namespace common\fixtures\dictionary;

use dictionary\models\DictSchools;
use yii\test\ActiveFixture;

class DictSchoolsFixture extends ActiveFixture
{
    public $modelClass = DictSchools::class;
    public $depends = [
        CountryFixture::class,
        RegionFixture::class];
}