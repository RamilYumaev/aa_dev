<?php


namespace modules\exam\helpers;


use modules\exam\models\ExamQuestionNested;
use yii\helpers\ArrayHelper;

class ExamQuestionNestedHelper
{
    public static function questionPropositionList($que_id): array
    {
        return ArrayHelper::map(ExamQuestionNested::find()->where(['question_id'=>$que_id])->asArray()->all(), "id", 'name');
    }

    private static function questionPropositionOne($id): ExamQuestionNested
    {
        return ExamQuestionNested::findOne($id);
    }

    public static function type($id) {
        return self::questionPropositionOne($id)->type;
    }

    public static function isStart($id) {
        return self::questionPropositionOne($id)->is_start;
    }



}