<?php
namespace frontend\controllers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\RegisterCompetitionList;
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
            'competition_list.ais_cg_id'=> $cg,
            'status'=> RegisterCompetitionList::STATUS_SUCCESS,
            'type'=> $type
        ]);

        $query1= clone $query;

        $dates = $query->select('date')->groupBy('date')->orderBy(['date'=>SORT_DESC])->column();

        if(!$dates) {
            return $this->redirect('index');
        }

        $rCls = $query1->andWhere(['date' => $date ?? $dates[0]])->orderBy(['number_update'=> SORT_ASC])->all();

        $cgModel =DictCompetitiveGroup::find()->aisId($cg)->one();

        return $this->render('entrant-list',['dates'=> $dates,
            'cg' => $cgModel, 'type' => $type, 'rCls' => $rCls, 'date'=> $date, 'id'=> $id]);
    }

}