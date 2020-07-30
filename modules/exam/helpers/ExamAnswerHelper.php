<?php

namespace modules\exam\helpers;

use modules\exam\models\ExamAnswer;
use testing\models\Answer;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class ExamAnswerHelper
{
    public static function answerList($que_id): array
    {
        return ExamAnswer::find()->select(['name','id'])->where(['question_id'=>$que_id])->andWhere(['not',['name'=>""]])
            ->orderBy( new Expression('rand()'))->indexBy('id')->column();
    }

    public static function answerMatchingList($que_id): array
    {
        return ArrayHelper::map(ExamAnswer::find()->where(['question_id'=>$que_id])->orderBy( new Expression('rand()'))->asArray()->all(), "answer_match", 'answer_match');
    }

    public static function answerNameOne($id): ? string
    { $answer = ExamAnswer::findOne($id);
        return  $answer ? $answer->name : null ;
    }

    public static function answerNameAll($ids)
    {
        return ExamAnswer::find()->where(['id'=>$ids])->select('name')->column();
    }

    public static function answerMatching($que_id): array
    {
        return ArrayHelper::map(ExamAnswer::find()->where(['question_id'=>$que_id])->andWhere(['not',['name'=>""]])->asArray()->all(), "id", 'name');
    }

}