<?php

namespace common\fixtures\olympic;

use common\fixtures\dictionary\DictChairmansFixture;
use common\fixtures\dictionary\DictClassFixture;
use olympic\models\OlimpicList;
use yii\test\ActiveFixture;
use common\fixtures\dictionary\FacultyFixture;
use common\fixtures\dictionary\DictCompetitiveGroupFixture;

class OlympicListFixture extends ActiveFixture
{
    public $modelClass = OlimpicList::class;
    public $depends = [DictChairmansFixture::class, OlympicFixture::class, FacultyFixture::class, DictCompetitiveGroupFixture::class, DictClassFixture::class];
}