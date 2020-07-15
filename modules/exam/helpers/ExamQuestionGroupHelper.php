<?php


namespace modules\exam\helpers;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictExaminer;
use modules\dictionary\models\ExaminerDiscipline;
use modules\exam\models\ExamQuestionGroup;

class ExamQuestionGroupHelper
{
    public static function listQuestionGroupIds($ids) {
        return ExamQuestionGroup::find()->select(['name','id'])
            ->andWhere(['discipline_id'=> $ids])
            ->indexBy('id')->column();
    }

    public static function listQuestionGroup() {
        return ExamQuestionGroup::find()->select(['name','id'])
            ->indexBy('id')->column();
    }
}