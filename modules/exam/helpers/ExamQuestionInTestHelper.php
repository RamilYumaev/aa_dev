<?php

namespace modules\exam\helpers;
use modules\exam\models\ExamQuestionInTest;
use testing\models\TestAndQuestions;

class ExamQuestionInTestHelper
{
    const MARK_SUM_TEST = 100;

    public static function questionTestGroupCount ($id) {
        return ExamQuestionInTest::find()->where(['question_group_id' => $id])->count();
    }

    public static function markSum ($test_id) {
        return  self::questionsTest($test_id)->sum('mark');
    }

    public static function countQuestions ($test_id) {
        return  self::questionsTest($test_id)->count();
    }

    public static function countNullMarkQuestions($test_id) {
        return  self::questionsTest($test_id)->andWhere(['mark'=> null])->count();
    }

    public static function isMarkSumSuccess ($test_id) {
        return self::markSum($test_id)  == self::MARK_SUM_TEST;
    }

    private static function questionsTest($test_id) {
        return  ExamQuestionInTest::find()->where(['test_id' => $test_id]);
    }
}