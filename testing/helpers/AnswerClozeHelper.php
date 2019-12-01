<?php

namespace testing\helpers;

use testing\models\AnswerCloze;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


class AnswerClozeHelper
{
    public static function answerMatchingList($quest_prop_id): array
    {
        return ArrayHelper::map(AnswerCloze::find()->where(['quest_prop_id'=>$quest_prop_id])->orderBy( new Expression('rand()'))->asArray()->all(), "name", 'name');
    }

}