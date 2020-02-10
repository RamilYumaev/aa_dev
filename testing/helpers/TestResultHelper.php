<?php

namespace testing\helpers;

use testing\models\Test;
use testing\models\TestClass;
use testing\models\TestQuestion;
use testing\models\TestResult;
use yii\helpers\ArrayHelper;
use olympic\helpers\OlympicListHelper;

class TestResultHelper
{
    public static function countQuestionAll($testAttempt) {
        return TestResult::find()->where(['attempt_id'=>$testAttempt])->count();
    }

    public static function countQuestionNoAutomaticAnswerAll($testAttempt) {
        return TestResult::find()->alias('result')
            ->innerJoin(TestQuestion::tableName(). ' question', 'question.id = result.question_id')
            ->andWhere(['result.attempt_id'=>$testAttempt])
            ->andWhere(['in', 'question.type_id',[TestQuestionHelper::TYPE_FILE, TestQuestionHelper::TYPE_ANSWER_DETAILED]])
            ->count();
    }

    public static function countQuestionNoAutomaticAnswerNotNullMarkAll($testAttempt) {
        return TestResult::find()->alias('result')
            ->innerJoin(TestQuestion::tableName(). ' question', 'question.id = result.question_id')
            ->andWhere(['result.attempt_id'=>$testAttempt])
            ->andWhere(['in', 'question.type_id',[TestQuestionHelper::TYPE_FILE, TestQuestionHelper::TYPE_ANSWER_DETAILED]])
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