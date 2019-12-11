<?php

namespace testing\helpers;

use testing\models\Answer;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


class AnswerHelper
{
    public static function answerList($que_id): array
    {
        return ArrayHelper::map(Answer::find()->where(['quest_id'=>$que_id])->andWhere(['not',['name'=>""]])->orderBy( new Expression('rand()'))->asArray()->all(), "id", 'name');
    }

    public static function answerMatchingList($que_id): array
    {
        return ArrayHelper::map(Answer::find()->where(['quest_id'=>$que_id])->orderBy( new Expression('rand()'))->asArray()->all(), "answer_match", 'answer_match');
    }

    public static function answerNameOne($id): ? string
    {
        return Answer::findOne($id)->name;
    }

    public static function answerNameAll($ids)
    {
        return Answer::find()->where(['id'=>$ids])->select('name')->column();
    }

    public static function answerMatching($que_id): array
    {
        return ArrayHelper::map(Answer::find()->where(['quest_id'=>$que_id])->andWhere(['not',['name'=>""]])->asArray()->all(), "id", 'name');
    }

}