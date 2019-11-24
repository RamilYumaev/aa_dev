<?php

namespace testing\helpers;

use testing\models\TestGroup;

class TestGroupHelper
{
    public static function testQuestionGroupList($id) {
        return TestGroup::find()->select('question_group_id')->andWhere(['test_id'=> $id])->column();
    }
}