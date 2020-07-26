<?php
namespace modules\exam\helpers;

use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamResult;



class ExamResultHelper
{
    public static function countQuestionAll($testAttempt) {
        return ExamResult::find()->where(['attempt_id'=>$testAttempt])->count();
    }

    public static function countQuestionNoAutomaticAnswerAll($testAttempt) {
        return ExamResult::find()->alias('result')
            ->innerJoin(ExamQuestion::tableName(). ' question', 'question.id = result.question_id')
            ->andWhere(['result.attempt_id'=>$testAttempt])
            ->andWhere(['in', 'question.type_id',[ExamQuestionHelper::TYPE_FILE, ExamQuestionHelper::TYPE_ANSWER_DETAILED]])
            ->count();
    }

    public static function countQuestionNoAutomaticAnswerNotNullMarkAll($testAttempt) {
        return ExamResult::find()->alias('result')
            ->innerJoin(ExamQuestion::tableName(). ' question', 'question.id = result.question_id')
            ->andWhere(['result.attempt_id'=>$testAttempt])
            ->andWhere(['in', 'question.type_id',[ExamQuestionHelper::TYPE_FILE, ExamQuestionHelper::TYPE_ANSWER_DETAILED]])
            ->andWhere(['is not', 'result.mark', null])
            ->count();
    }

    public static function equallyCount($testAttempt) {
        return self::countQuestionAll($testAttempt) == self::countQuestionNoAutomaticAnswerAll($testAttempt);
    }

    public static function noEquallyQuestionCount($testAttempt) {
        return  self::countQuestionNoAutomaticAnswerNotNullMarkAll($testAttempt) !== self::countQuestionNoAutomaticAnswerAll($testAttempt);
    }

    public static function isPreResult($attempt) {
        return self::equallyCount($attempt) && self::noEquallyQuestionCount($attempt);
    }

    public static function isPreResultAll($attempt) {
        return !self::equallyCount($attempt) && self::noEquallyQuestionCount($attempt);
    }

}