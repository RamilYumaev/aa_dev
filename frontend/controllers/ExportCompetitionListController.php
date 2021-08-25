<?php
namespace frontend\controllers;
use common\components\TbsWrapper;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\CompetitionList;
use modules\entrant\helpers\DateFormatHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ExportCompetitionListController extends Controller
{



    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'table-file' => ['POST']
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['entrant']
                    ]
                ],
            ],
        ];
    }

        /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionTableFile($id)
    {
        $model = CompetitionList::findOne($id);
        if(!$model) {
            throw new NotFoundHttpException('Ничего не найдено');
        }
        $fileName = $model->id.".xlsx";
        $filePath = \Yii::getAlias('@common').'/file_templates/i_list_phone.xlsx';
        $dataCommon = $this->getCommon($model);
        $dataApp = $this->getApplications($model);
        $this->openFile($filePath, $dataCommon,  $dataApp, $fileName);
    }

    public function openFile($filePath, $dataCommon,  $dataApp, $fileName) {
        $tbs = new TbsWrapper();
        $tbs->openTemplate($filePath);
        $tbs->merge('common', $dataCommon);
        $tbs->merge('application', $dataApp);
        $tbs->download($fileName);
    }

    protected function getApplications(CompetitionList $model)
    {
        $path = \Yii::getAlias('@modules') . $model->json_file;
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        /** @var DictCompetitiveGroup $cg */
        $cg = $model->registerCompetitionList->cg;
        $subjectType = [1 => 'ЕГЭ', 2 => 'ЦТ', 3 => 'ВИ', 4 => 'СБА'];
        $subjectStatus = [1 => 'не проверено', 2 => 'проверено', 3 => 'ниже минимума', 4 => 'истек срок'];
        $aisCseIdCg = $cg->getExaminationsCseAisId();
        $aisCtIdCg = $cg->getExaminationsCtAisId();
        $examinations = $cg->getExaminationsAisId();
        $compositeId = $cg->getCompositeDisciplineId();
        $selectDiscipline = \dictionary\models\CompositeDiscipline::getOne($compositeId);
        foreach ($data[$model->type] as $list => $value) {
            foreach ($value['subjects'] as $key => $subject) {
                if ($subject['subject_type_id'] == 1) {
                    $aisCseId = $aisCseIdCg[$subject['subject_id']];
                    if (key_exists($aisCseId, $selectDiscipline)) {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $selectDiscipline[$aisCseId];
                    } else {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $aisCseId;
                    }
                } elseif ($subject['subject_type_id'] == 2) {
                    $aisCtId = $aisCtIdCg[$subject['subject_id']];
                    if (key_exists($aisCtId, $selectDiscipline)) {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $selectDiscipline[$aisCtId];
                    } else {
                        $data['list'][$list]['subjects'][$key]['subject_id'] = $aisCtId;
                    }
                }
            }
        }
        $i = 0;
        $application = [];
        foreach ($data[$model->type] as $key => $entrant) {
            $application[$key]['num'] = ++$i;
            $application[$key]['full_name'] = $entrant['last_name']." ". $entrant['first_name']." ". $entrant['patronymic'];
            $application[$key]['number'] = key_exists('snils', $entrant) ? ($entrant['snils'] ? $entrant['snils'] : $entrant['incoming_id']) : $entrant['incoming_id'];
            if($entrant['zos_status_id'] === 0) {
                $application[$key]['consent_status'] = "-";
            }
            elseif($entrant['zos_status_id'] === 1) {
                $application[$key]['consent_status'] = "+";
            }else {
                $application[$key]['consent_status'] = "др.н.п";
            }
            $application[$key]['individual_achievements'] = key_exists('individual_achievements', $entrant) ? (implode(', ', array_map(function($individual_achievement)
                { return $individual_achievement['individual_achievement_name'].' - '. $individual_achievement['ball'];}, $entrant['individual_achievements']))) : "" ;
            $application[$key]['mark_sum'] =$entrant['total_sum'];
            $application[$key]['mob_number'] =  key_exists('phone',$entrant) ? $entrant['phone'] : '-';
            $application[$key]['home_number'] =  '-';
            $application[$key]['hostel_status'] = $entrant['hostel_need_status_id'] ? 'Да': 'Нет';
            $application[$key]['note'] =  key_exists('pp_status_id',$entrant) && $entrant['pp_status_id'] ? "ПП" : '';
            $b=0;
            foreach ($examinations as $aisKey => $value) {
                $b++;
                $keyS = array_search($aisKey, array_column($entrant['subjects'], 'subject_id'));
                $subject = $entrant['subjects'][$keyS];
                $application[$key]['subject_mark_'.$b] = (key_exists('ball', $subject) && $subject['ball'] ? $subject['ball'].", " : '').
                $subjectType[$subject['subject_type_id']].
                (key_exists('check_status_id', $subject) && $subject['check_status_id'] ? ", ".$subjectStatus[$subject['check_status_id']] :"");
               }
        }
        return $application;
    }

    protected function getCommon(CompetitionList $model)  {

        $path = \Yii::getAlias('@modules').$model->json_file;
        $json = file_get_contents($path);
        $data = json_decode($json,true);
        /** @var DictCompetitiveGroup $cg */
        $cg = $model->registerCompetitionList->cg;
        $examinations = $cg->getExaminationsAisId();

        $array = [];
        $array[0]['academic_year'] =  "2021/2022";
        $array[0]['date'] =  DateFormatHelper::format($model->datetime, 'd.m.Y. H:i');
        $array[0]['category'] = $model->getTypeName($cg->special_right_id);
        $array[0]['faculty'] = $cg->faculty->full_name;
        $array[0]['specialty_code'] = $cg->specialty->code;
        $array[0]['specialty_name'] = $cg->specialty->name;
        $array[0]['education_level'] = $cg->eduLevelFull;
        $array[0]['specialization'] = $cg->specialisationName;

        $array[0]['education_form'] = $cg->formEdu;
        $array[0]['financing_type'] = $cg->finance;
        $array[0]['kcp_show'] = $cg->isBudget() ? true : false;
        $array[0]['kcp'] = $data['kcp']['sum'];
        $array[0]['transferred'] = $data['kcp']['transferred'];
        $array[0]['vacant'] =  $cg->isBudget() ? $data['kcp']['sum'] - $data['kcp']['transferred'] : 0;
        $i=0;
        foreach ($examinations as $value) {
            $i++;
            $array[0]['exam_'.$i] = $value;
        }
        if(!key_exists('exam_2', $array[0])) {
            $array[0]['exam_2'] = '';
        }
        if(!key_exists('exam_3', $array[0])) {
            $array[0]['exam_3'] = '';
        }
        return $array;
    }

    public function getFullNameCL($cg)
    {
        return $cg->faculty->full_name . " / " . $cg->specialty->codeWithName;
    }




}