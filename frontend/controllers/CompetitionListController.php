<?php
namespace frontend\controllers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\RegisterCompetitionList;
use yii\db\ActiveQuery;
use yii\web\Controller;

class CompetitionListController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSpo()
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO, true);
    }

    protected function renderCompetitionList($eduLevel, $department) {
        return $this->render('_data',['faculty' =>
            $this->getFaculty($eduLevel, $department),
            'title' => CompetitionList::listTitle($department)[$eduLevel]['name'],
            'eduLevel' => $eduLevel,
        ]);
    }

    protected function getFaculty($eduLevel, $department = true) {
        $query = DictCompetitiveGroup::find()->joinWith('faculty')
            ->eduLevel($eduLevel)
            ->select(['faculty_id','full_name'])
            ->foreignerStatus(false)
            ->tpgu(false)
            ->groupBy('faculty_id')->orderBy(['full_name'=>SORT_ASC]);
        if($department) {
            $query->filialAndCollege();
        }else{
            $query->notInFaculty();
        }
        return $query->all();
    }

    public function actionDepartment()
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR, true);
    }

    public function actionBachelor()
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR, false);
    }

    public function actionMagistracy()
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER, false);
    }

    public function actionGraduate()
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL, false);

    }

    public function actionEntrantList($cg, $type, $date = null, $id = null)
    {
        $query = RegisterCompetitionList::find()
        ->joinWith('competitionList')
        ->andWhere([
            'ais_cg_id'=> $cg,
            'status'=> RegisterCompetitionList::STATUS_SUCCESS,
            'type'=> $type
        ]);

        $cgModel = DictCompetitiveGroup::find()->aisId($cg)->one();

        return $this->renderCompetitionOneList($query, $type, $date, $id,
            $cgModel->faculty_id,
            $cgModel->edu_level,
            $cgModel->special_right_id,
            $cgModel->financing_type_id,
            $cgModel->speciality_id,
            $cgModel->education_form_id,
            $cgModel->faculty->filial, $cgModel->ais_id);
    }

    public function actionEntrantGraduateList($faculty, $speciality, $finance, $form, $type, $special = null, $date = null, $id = null)
    {
        $eduLevel = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
        $query = RegisterCompetitionList::find()
            ->joinWith(['competitionList', 'settingEntrant'])
            ->andWhere([
                'status'=> RegisterCompetitionList::STATUS_SUCCESS,
                'special_right' =>  $special,
                'edu_level' =>  $eduLevel,
                'form_edu' => $form,
                 RegisterCompetitionList::tableName().'.faculty_id' => $faculty,
                'speciality_id' => $speciality,
                'finance_edu' => $finance,
                 CompetitionList::tableName().'.type'=> $type
            ]);

        return $this->renderCompetitionOneList($query, $type, $date, $id,  $faculty, $eduLevel, $special, $finance, $speciality, $form);
    }

    protected function renderCompetitionOneList(ActiveQuery $query,
                                                $type,
                                                $date,
                                                $id,
                                                $faculty,
                                                $eduLevel,
                                                $special,
                                                $finance,
                                                $speciality,
                                                $form,
                                                $isFilial = false, $cg = null) {
        $query1= clone $query;

        $dates = $query->select('date')->groupBy('date')->orderBy(['date'=>SORT_DESC])->column();

        if(!$dates) {
            return $this->redirect('index');
        }

        $rCls = $query1->andWhere(['date' => $date ?? $dates[0]])->orderBy(['number_update'=> SORT_ASC])->all();
        $array = [
            'dates'=> $dates,
            'type' => $type,
            'rCls' => $rCls,
            'date'=> $date ?? $dates[0],
            'id'=> $id,
            'faculty'=> $faculty,
            'eduLevel' =>$eduLevel,
            'isFilial' => $isFilial,
            'special' =>  $special,
            'formEdu' => $form,
            'speciality' => $speciality,
            'finance' => $finance,
            'aisId' => $cg
        ];
        return $this->render('entrant-list', $array);
    }
}