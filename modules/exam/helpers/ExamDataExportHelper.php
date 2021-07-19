<?php

namespace modules\exam\helpers;

use dictionary\helpers\DictFacultyHelper;
use dictionary\models\Faculty;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementCg;
use modules\exam\models\Exam;
use modules\exam\models\ExamAttempt;
use yii\helpers\Html;

class ExamDataExportHelper
{

    public static function dataExportExamAll($examId, $type, $filial)
    {
        $exam = Exam::findOne($examId);
        $aisIdDiscipline = $exam->discipline->ais_id;
        $cse = $exam->discipline->cse_subject_id;
        $disciplineCg = $exam->discipline->disciplineCgAisColumn($filial);
        $examAttempts = ExamAttempt::find()->type($type)->exam($exam->id)->select(['exam_attempt.user_id', 'mark'])->joinWith('statement')
            ->andWhere(['statement.faculty_id' => $filial ? $filial : Faculty::find()->andWhere(['filial' => false])->column()])
            ->andWhere(['statement.status' => StatementHelper::STATUS_ACCEPTED])
            ->distinct()
            ->all();
        $n = 0;
        $exams = [1, 2, 3, 4, 8, 19];
        $result['exam']['exam_list'] = [
            "through_examination_status" => in_array($exam->discipline_id, $exams) ? 1 : 0,
            "entrance_examination_id" => $aisIdDiscipline,
            "dates" => $type ? $exam->date_start_reserve : $exam->date_start,
        ];
        $result["exam"]["exam_cg"] = $disciplineCg;
        foreach ($examAttempts as $attempt) {
            /* @var $attempt \modules\exam\models\ExamAttempt */
            $result["exam"]["exam_incoming"][$n] = [
                "internal_discipline_id" => "",
                'incoming_id' => $attempt->profile->ais->incoming_id,
                'mark' => $attempt->mark,
            ];
            $n++;

        }

        return $result;
    }

    public static function linkExport($examId, $type)
    {
        return Html::a("Экспорт в АИС " . $type, ['communication/export-data', 'examId' => $examId, 'type' => $type], ['data-method' => 'post', 'class' => 'btn btn-success']) . " "
            . Html::a("Экспорт в АИС Анапа " . $type, ['communication/export-data', 'examId' => $examId, 'type' => $type, 'filial' => \dictionary\helpers\DictFacultyHelper::ANAPA_BRANCH], ['data-method' => 'post', 'class' => 'btn btn-success']) . " "
            . Html::a("Экспорт в АИС Покров " . $type, ['communication/export-data', 'examId' => $examId, 'type' => $type, 'filial' => \dictionary\helpers\DictFacultyHelper::POKROV_BRANCH], ['data-method' => 'post', 'class' => 'btn btn-success']) . " "
            . Html::a("Экспорт в АИС Ставрополь " . $type, ['communication/export-data', 'examId' => $examId, 'type' => $type, 'filial' => \dictionary\helpers\DictFacultyHelper::STAVROPOL_BRANCH], ['data-method' => 'post', 'class' => 'btn btn-success']) . " "
            . Html::a("Экспорт в АИС Дербент " . $type, ['communication/export-data', 'examId' => $examId, 'type' => $type, 'filial' => \dictionary\helpers\DictFacultyHelper::DERBENT_BRANCH], ['data-method' => 'post', 'class' => 'btn btn-success']) . " "
            . Html::a("Экспорт в АИС Сергиев-Посад " . $type, ['communication/export-data', 'examId' => $examId, 'type' => $type, 'filial' => \dictionary\helpers\DictFacultyHelper::SERGIEV_POSAD_BRANCH], ['data-method' => 'post', 'class' => 'btn btn-success']) . " "
            . Html::a("json " . $type, ['communication/json-data', 'examId' => $examId, 'type' => $type], ['data-method' => 'post', 'class' => 'btn btn-warning']);
    }


}