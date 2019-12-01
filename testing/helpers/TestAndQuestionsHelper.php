<?php

namespace testing\helpers;
use testing\models\TestAndQuestions;

class TestAndQuestionsHelper
{
    const MARK_SUM_TEST = 100;

    public static function questionTestGroupCount ($id) {
        return TestAndQuestions::find()->where(['test_group_id' => $id])->count();
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
        return  TestAndQuestions::find()->where(['test_id' => $test_id]);
    }
}