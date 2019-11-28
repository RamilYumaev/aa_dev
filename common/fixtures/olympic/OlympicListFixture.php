<?php

namespace common\fixtures\olympic;

use common\fixtures\dictionary\DictChairmansFixture;
use common\fixtures\dictionary\DictClassFixture;
use common\fixtures\dictionary\DictCompetitiveGroupFixture;
use olympic\models\OlimpicList;
use yii\test\ActiveFixture;
use common\fixtures\dictionary\FacultyFixture;

class OlympicListFixture extends ActiveFixture
{
    public $modelClass = OlimpicList::class;
    public $depends = [DictChairmansFixture::class, OlympicFixture::class, FacultyFixture::class,
        DictClassFixture::class, DictCompetitiveGroupFixture::class];
}