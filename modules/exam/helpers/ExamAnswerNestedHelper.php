<?php

namespace modules\exam\helpers;

use modules\exam\models\ExamAnswerNested;
use testing\models\AnswerCloze;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


class ExamAnswerNestedHelper
{
    public static function answerMatchingList($quest_prop_id): array
    {
        return ArrayHelper::map(ExamAnswerNested::find()->where(['question_nested_id'=>$quest_prop_id])->orderBy( new Expression('rand()'))->asArray()->all(), "name", 'name');
    }

}