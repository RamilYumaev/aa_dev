<?php

namespace testing\helpers;
use testing\models\TestAndQuestions;

class TestAndQuestionsHelper
{
    public static function questionTestGroupCount ($id) {
        return TestAndQuestions::find()->where(['test_group_id' => $id])->count();
    }
}