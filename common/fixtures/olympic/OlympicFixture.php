<?php

namespace common\fixtures\olympic;

use olympic\models\Olympic;
use yii\test\ActiveFixture;
use common\fixtures\dictionary\DictCompetitiveGroupFixture;
use common\fixtures\dictionary\FacultyFixture;

class OlympicFixture extends ActiveFixture
{
    public $modelClass = Olympic::class;
    public $depends = [FacultyFixture::class, DictCompetitiveGroupFixture::class];
}