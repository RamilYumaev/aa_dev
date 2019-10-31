<?php

namespace common\fixtures\dictionary;

use dictionary\models\DictCompetitiveGroup;
use yii\test\ActiveFixture;

class DictCompetitiveGroupFixture extends ActiveFixture
{
    public $modelClass = DictCompetitiveGroup::class;
    public $depends = [
        DisciplineCompetitiveGroupFixture::class,
        FacultyFixture::class,
        DictSpecialityFixture::class,
        DictSpecializationFixture::class,
        ];
}