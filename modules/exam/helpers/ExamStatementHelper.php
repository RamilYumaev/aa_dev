<?php
namespace modules\exam\helpers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictDiscipline;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\exam\models\Exam;
use modules\exam\models\ExamStatement;
use Yii;

class ExamStatementHelper
{
    const RESERVE_TYPE = 2;
    const USUAL_TYPE_ZA_OCH = 1;
    const USUAL_TYPE_OCH = 0;

    const WALT_STATUS = 0;
    const SUCCESS_STATUS = 1;
    const ERROR_RESERVE_STATUS = 2;
    const END_STATUS = 3;
    const RESERVE_STATUS = 4;
    const CANCEL_STATUS = 5;
    const ABSENCE_STATUS = 6;

    public static function listTypes ()
    {
        return [
            self::USUAL_TYPE_OCH  => "Основной",
            self::USUAL_TYPE_ZA_OCH  => "Основной (заочная форма)",
            self::RESERVE_TYPE => "Резервный",
        ];
    }

    public static function timeList ()
    {
        return [
            "10:00"  => "10:00" ,
            "12:00"  => "12:00" ,
            "14:00"  => "14:00" ,
            "16:00"  => "16:00" ,
            "18:00"  => "18:00" ,
        ];
    }

    public static function timeSpecList ()
    {
        return [
            "10:00"  => "10:00" ,
            "10:15"  => "10:15" ,
            "10:30"  => "10:30" ,
            "10:45"  => "10:45" ,
            "11:00"  => "11:00" ,
            "11:15"  => "11:15" ,
            "11:30"  => "11:30" ,
            "11:45"  => "11:45" ,
            "12:00"  => "12:00" ,
            "12:15"  => "12:15" ,
            "12:30"  => "12:30" ,
            "12:45"  => "12:45" ,
            "13:00"  => "13:00" ,
            "13:15"  => "13:15" ,
            "13:30"  => "13:30" ,
            "13:45"  => "13:45" ,
            "14:00"  => "14:00" ,
            "14:15"  => "14:15" ,
            "14:30"  => "14:30" ,
            "14:45"  => "14:45" ,
            "15:00"  => "15:00" ,
            "15:15"  => "15:15" ,
            "15:30"  => "15:30" ,
            "15:45"  => "15:45" ,
            "16:00"  => "16:00" ,
            "16:15"  => "16:15" ,
            "16:30"  => "16:30" ,
            "16:45"  => "16:45" ,
            "17:00"  => "17:00" ,
            "17:15"  => "17:15" ,
            "17:30"  => "17:30" ,
            "17:45"  => "17:45" ,
            "18:00"  => "18:00" ,
            "18:15"  => "18:15" ,
            "18:30"  => "18:30" ,
            "18:45"  => "18:45" ,
            "19:00"  => "19:00" ,
            "19:15"  => "19:15" ,
            "19:30"  => "19:30" ,
            "19:45"  => "19:45" ,
            "20:00"  => "20:00" ,
            "20:15"  => "20:15" ,
            "20:30"  => "20:30" ,
            "20:45"  => "20:45" ,
            "21:00"  => "21:00" ,
            "21:15"  => "21:15" ,
            "21:30"  => "21:30" ,
            "21:45"  => "21:45" ,
            "22:00"  => "22:00" ,
            "22:15"  => "22:15" ,
            "22:30"  => "22:30" ,
            "22:45"  => "22:45" ,
            "23:00"  => "23:00"
        ];

    }




    public static function listStatus ()
    {
        return [
            self::WALT_STATUS => "Ожидание",
            self::SUCCESS_STATUS => "Допущен",
            self::ERROR_RESERVE_STATUS => "Нарушение/Резервный",
            self::END_STATUS => "Завершен",
            self::RESERVE_STATUS => "Перенос на резервный день",
            self::CANCEL_STATUS => "Аннулирован",
            self::ABSENCE_STATUS => "Неявка",
        ];
    }

    public static function listStatusColor ()
    {
        return [
            self::WALT_STATUS => "label label-default",
            self::SUCCESS_STATUS => "label label-success",
            self::ERROR_RESERVE_STATUS => "label label-danger",
            self::END_STATUS => "label label-primary",
            self::RESERVE_STATUS => "label label-info",
            self::CANCEL_STATUS => "label label-danger",
            self::ABSENCE_STATUS => "label label-danger",
        ];
    }

    public static function entrantList() {
        $jobEntrant = Yii::$app->user->identity->jobEntrant();

        $examStatement = ExamStatement::find()->joinWith('profileEntrant')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)', 'entrant_user_id']);
        if ($jobEntrant && $jobEntrant->category_id == JobEntrantHelper::TRANSFER) {
            $exam = Exam::find()->joinWith('discipline')
                ->select(['exam.id']);
            $exam->andWhere(['faculty_id' => $jobEntrant->faculty_id]);
            $data =   $exam->indexBy('exam.id')->column();
            $examStatement  ->andWhere(['exam_id' => $data]);
        }

        return $examStatement->indexBy('entrant_user_id')->column();
    }

    public static function proctorList() {
        return ExamStatement::find()->joinWith('profileProctor')
            ->select(['CONCAT(last_name, \' \', first_name,  \' \', patronymic)', 'proctor_user_id'])
            ->indexBy('proctor_user_id')->column();
    }

}