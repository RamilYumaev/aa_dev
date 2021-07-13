<?php

namespace console\controllers;


use Codeception\Lib\Di;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\forms\SettingCompetitionListForm;
use modules\dictionary\forms\SettingEntrantForm;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\searches\SettingEntrantSearch;
use modules\dictionary\services\SettingCompetitionListService;
use modules\dictionary\services\SettingEntrantService;
use modules\entrant\helpers\AnketaHelper;
use yii\console\Controller;

class SettingGenerateController extends Controller
{

    public $service;
    public $model;
    public $formModel;
    public $searchModel;
    public $competitionListService;
    public $competitionListForm;
    public function __construct($id, $module,
                                SettingEntrantService $service,
                                SettingCompetitionListService $competitionListService,
                                SettingCompetitionListForm $competitionListForm,
                                SettingEntrant $model,
                                SettingEntrantForm $formModel,
                                SettingEntrantSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
        $this->competitionListForm = $competitionListForm;
        $this->competitionListService =$competitionListService;
    }

    public function actionSetSetting()
    {
        $departments = [
            AnketaHelper::HEAD_UNIVERSITY,
            AnketaHelper::ANAPA_BRANCH,
            AnketaHelper::POKROV_BRANCH,
            AnketaHelper::STAVROPOL_BRANCH,
            AnketaHelper::DERBENT_BRANCH,
            DictFacultyHelper::COLLAGE];

        $type = [SettingEntrant::ZUK, SettingEntrant::ZOS];
        $dvi = [0, 1];
        $cseAsVi = [0, 1];
        $ums = [0, 1];

        $key = 0;
        foreach ($type as $typeApp) {
            foreach ($ums as $foreignerStatus) {
                foreach ($dvi as $dopVi) {
                    foreach ($cseAsVi as $cVi) {
                        foreach ($departments as $depart) {
                            $eduLevel = $this->getEducationLevel($depart, $foreignerStatus);
                            foreach ($eduLevel as $level) {
                                $eduForm = $this->getEducationForm($depart, $level, $foreignerStatus);
                                foreach ($eduForm as $form) {
                                    $financingType = $this->getDbFinanceArray($depart, $level, $form, $foreignerStatus);

                                    $competitionType = $this->getCompetitionsType($depart, $level, $form, $foreignerStatus);

                                    foreach ($competitionType as $comType) {
                                        foreach ($financingType as $finance) {
                                            if ($cVi && (
                                                    $level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO || $level ==
                                                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER ||
                                                    $level == DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL)) {
                                                continue;
                                            }
                                            if ($comType !== null && $finance == DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT) {
                                                continue;
                                            }

                                            if ($foreignerStatus && $cVi) {
                                                continue;
                                            }
                                            $model = new $this->formModel;
                                            $model->foreign_status = $foreignerStatus;
                                            $model->edu_level = $level;
                                            $model->note = "Настройка № $key";
                                            $model->faculty_id = $depart;
                                            $model->form_edu = $form;
                                            $model->datetime_start = '2021-06-17 00:00:00';
                                            $model->datetime_end = '2021-06-19 00:00:00';
                                            $model->cse_as_vi = $cVi;
                                            $model->is_vi = $dopVi;
                                            $model->type = $typeApp;
                                            $model->finance_edu = $finance;
                                            $model->special_right = $comType;
                                            $model->tpgu_status = 0;

                                            $settingEntrant = $this->service->create($model);

                                            $eyeCount = $settingEntrant->isGraduate() ? count($settingEntrant->getAllGraduateCgAisId()) : count($settingEntrant->getAllCgAisId());
                                            $model->note = $settingEntrant->note . ". Количество КГ $eyeCount";

                                            $this->service->edit($settingEntrant->id, $model);
                                            $key++;

                                        }
                                    }

                                }
                            }
                        }
                    }
                }
            }
        }

        return 'Выполнено $key итераций';

    }

    public function actionSetList() {
        /** @var SettingEntrant $st */
        foreach (SettingEntrant::find()->type(SettingEntrant::ZOS)->isCseAsVi(false)->foreign(false)->all() as $st)  {
            $model = new $this->competitionListForm;
            $model->date_start = $st->getDateStart();
            $model->date_end = $st->getDateEnd();
            $model->time_start = "10:00:00";
            $model->time_end = "20:00:00";
            $model->se_id =  $st->id;
            $model->time_start_week = "10:00:00";
            $model->time_end_week = "15:00:00";
            $model->interval = 7;
            $model->date_ignore =[];
            $model->is_auto = 1;
            $model->end_date_zuk = null;
            $this->competitionListService->create($model);
        }
    }

    public function actionUpdate() {
        /** @var SettingEntrant $st */
        foreach (SettingEntrant::find()->type(SettingEntrant::ZUK)
                     ->isVi(true)
                     ->eduFinance(DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT)
                     ->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR)
                     ->eduForm([DictCompetitiveGroupHelper::EDU_FORM_OCH,
                         DictCompetitiveGroupHelper::EDU_FORM_OCH_ZAOCH])
                     ->foreign(false)->all() as $st)  {
            $st->datetime_end = '2021-07-29 18:00:00';
            $st->save();
        }
    }


    public function actionUpdateZid() {
        /** @var SettingEntrant $st */
        foreach (SettingEntrant::find()->type(SettingEntrant::ZUK)
                     ->eduFinance(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET)
            ->eduLevel(
                [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL])->foreign(false)->all() as $st)  {
            $model = new $this->formModel;
            $model->foreign_status = $st->foreign_status;
            $model->edu_level = $st->edu_level;
            $model->note = "Настройка № ZID " . $st->id;
            $model->faculty_id = $st->faculty_id;
            $model->form_edu = $st->form_edu;
            $model->datetime_start = '2021-06-19 10:00:00';
            $model->datetime_end = '2021-08-30 18:00:00';
            $model->cse_as_vi = $st->cse_as_vi;
            $model->is_vi = $st->is_vi;
            $model->type = SettingEntrant::ZID;
            $model->finance_edu = $st->finance_edu;
            $model->special_right = $st->special_right;
            $model->tpgu_status = 0;

            $this->service->create($model);
        }
    }


    private function getEducationLevel($depart, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->currentAutoYear()
            ->foreignerStatus($foreignerStatus)
            ->select('edu_level')
            ->departments($depart)
            ->groupBy('edu_level')
            ->tpgu(0)
            ->column();
    }

    private function getEducationForm($depart, $eduLevel, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->currentAutoYear()
            ->foreignerStatus($foreignerStatus)
            ->eduLevel($eduLevel)
            ->select('education_form_id')
            ->departments($depart)
            ->groupBy('education_form_id')
            ->tpgu(0)
            ->column();

    }

    private function getDbFinanceArray($depart, $educationLevel, $eduForm, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->select('financing_type_id')
            ->currentAutoYear()
            ->foreignerStatus($foreignerStatus)
            ->departments($depart)
            ->eduLevel($educationLevel)
            ->formEdu($eduForm)
            ->groupBy('financing_type_id')
            ->column();
    }

    private function getCompetitionsType($depart, $educationLevel, $eduForm, $foreignerStatus)
    {
        return DictCompetitiveGroup::find()
            ->select('special_right_id')
            ->currentAutoYear()
            ->departments($depart)
            ->foreignerStatus($foreignerStatus)
            ->eduLevel($educationLevel)
            ->formEdu($eduForm)
            ->groupBy('special_right_id')
            ->column();
    }

}