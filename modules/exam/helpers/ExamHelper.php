<?php
namespace modules\exam\helpers;
use dictionary\models\DictDiscipline;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\exam\models\Exam;
use Yii;

class ExamHelper
{
    public static function examList() {
        /* @var $jobEntrant JobEntrant*/
        $jobEntrant = Yii::$app->user->identity->jobEntrant();

         $exam = Exam::find()->joinWith('discipline')
            ->select([DictDiscipline::tableName().'.name', 'exam.id']);

         if ($jobEntrant && $jobEntrant->category_id == JobEntrantHelper::TRANSFER) {
             $exam->andWhere(['faculty_id' => $jobEntrant->faculty_id]);
         }
            return $exam->indexBy('exam.id')->column();
    }
}