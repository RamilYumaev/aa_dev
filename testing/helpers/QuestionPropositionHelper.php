<?php


namespace testing\helpers;


use testing\models\QuestionProposition;
use yii\helpers\ArrayHelper;

class QuestionPropositionHelper
{
    public static function questionPropositionList($que_id): array
    {
        return ArrayHelper::map(QuestionProposition::find()->where(['quest_id'=>$que_id])->asArray()->all(), "id", 'name');
    }

    private static function questionPropositionOne($id): QuestionProposition
    {
        return QuestionProposition::findOne($id);
    }

    public static function type($id) {
        return self::questionPropositionOne($id)->type;
    }

    public static function isStart($id) {
        return self::questionPropositionOne($id)->is_start;
    }



}