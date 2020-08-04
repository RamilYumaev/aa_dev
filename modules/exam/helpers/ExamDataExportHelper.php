<?php

namespace modules\exam\helpers;

use modules\entrant\helpers\AnketaHelper;
use modules\entrant\models\StatementCg;
use modules\exam\models\Exam;
use modules\exam\models\ExamAttempt;

class ExamDataExportHelper {

    public static function dataExportExamAll($examId, $type, $filial)
    {
        $exam = Exam::findOne($examId);
        $aisIdDiscipline = $exam->discipline->ais_id;
        $cse = $exam->discipline->cse_subject_id;
        $disciplineCg = $exam->discipline->disciplineCgAisColumn($filial);
        $examAttempts = ExamAttempt::find()->type($type)->exam($exam->id)->select(['exam_attempt.user_id', 'mark'])->joinWith('anketa')
            ->andWhere(['university_choice'=> $filial ?? AnketaHelper::HEAD_UNIVERSITY])
            ->all();
        $n = 0;
        $exams = [1,2,4,8,19];
        $result['exam']['exam_list'] = [
            "through_examination_status"=> in_array($exam->discipline_id, $exams) ? 1 : 0,
             "entrance_examination_id"=>$aisIdDiscipline,
             "dates"=> $type ? $exam->date_start_reserve : $exam->date_start,
        ];
        $result["exam"]["exam_cg"] =  $disciplineCg;
        foreach($examAttempts as $attempt) {
            /* @var $attempt \modules\exam\models\ExamAttempt */
            $result["exam"]["exam_incoming"][$n]=[
                "internal_discipline_id" =>"",
                'incoming_id' => $attempt->profile->ais->incoming_id,
                'mark' => !is_null($cse) ? ($attempt->mark >= $exam->discipline->cse->min_mark  ?
                    $attempt->mark : $exam->discipline->cse->min_mark) : ($attempt->mark >= 41   ?
                    $attempt->mark : 41),
            ];
            $n++;

        }

        return $result;
    }











}