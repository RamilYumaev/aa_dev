<?php
namespace modules\exam\helpers;
use dictionary\models\DictDiscipline;
use modules\exam\models\Exam;

class ExamHelper
{
    public static function examList() {
        return Exam::find()->joinWith('discipline')
            ->select([DictDiscipline::tableName().'.name', 'exam.id'])
            ->indexBy('exam.id')->column();
    }
}