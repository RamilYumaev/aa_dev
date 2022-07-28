<?php
namespace frontend\controllers;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\RegisterCompetitionList;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CompetitionListController extends Controller
{

//    public function behaviors(): array
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::class,
//                'actions' => [
//                    'table-file' => ['POST']
//                ]
//            ],
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@']
//                    ]
//                ],
//            ],
//        ];
//    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionListShort()
    {
        return $this->render('list-short');
    }


    public function actionSpo($faculty = null)
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO, true, $faculty);
    }

    protected function renderCompetitionList($eduLevel, $department, $faculty = null) {
        /** @var \yii\caching\FileCache $competitionListCache */
        $competitionListCache = \Yii::$app->competitionListCache;
        $cacheKey = ['renderCompetitionList', 'eduLevel' => $eduLevel, 'department' => $department, 'faculty' => $faculty, 'userId' => Yii::$app->user->id];

        return $competitionListCache->getOrSet($cacheKey, function () use ($eduLevel, $department, $faculty) {
            $modelFaculty = $this->faculty($faculty);

            return $this->render('_data',['faculty' =>
                $this->getFaculty($eduLevel, $department, $faculty),
                'title' => CompetitionList::listTitle($department)[$eduLevel]['name'],
                'eduLevel' => $eduLevel,
                'isFaculty' => $modelFaculty,
            ]);
        });
    }

    protected function getFaculty($eduLevel, $department, $faculty) {

            $query = DictCompetitiveGroup::find()->joinWith('faculty')
                ->eduLevel($eduLevel)
                ->select(['faculty_id','full_name'])
                ->foreignerStatus(false)
                ->currentAutoYear()
                ->tpgu(false);
            if($department) {
                $query->filialAndCollege();
            }else{
                $query->notInFaculty();
            }
            if($faculty) {
                $query->faculty($faculty);
            }
            return $query->groupBy('faculty_id')->orderBy(['full_name'=>SORT_ASC])->all();
    }

    public function actionDepartment($faculty = null)
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR, true, $faculty);
    }

    public function actionBachelor($faculty = null)
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR, false, $faculty);
    }

    public function actionMagistracy($faculty = null)
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER, false, $faculty);
    }

    public function actionGraduate($faculty = null)
    {
        return $this->renderCompetitionList(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL, false, $faculty);
    }

    protected function faculty($faculty) {
        return Faculty::findOne($faculty);
    }

    public function actionEntrantList($cg, $type, $date = null, $id = null)
    {
        /** @var \yii\caching\FileCache $competitionListCache */
        $competitionListCache = \Yii::$app->competitionListCache;

        $cacheKey = ['actionEntrantList', 'cg' => $cg, 'type' => $type, 'date' => $date, 'id' => $id, 'userId' => Yii::$app->user->id];

        return $competitionListCache->getOrSet($cacheKey, function () use ($cg, $type, $date, $id) {
            $query = RegisterCompetitionList::find()
                ->joinWith('competitionList')
                ->andWhere([
                    'ais_cg_id'=> $cg,
                    'status'=> RegisterCompetitionList::STATUS_SUCCESS,
                    'type'=> $type
                ]);

            $cgModel = DictCompetitiveGroup::find()->currentAutoYear()->aisId($cg)->one();

            if(!$cgModel) {
                return $this->render('index');
            }

            return $this->renderCompetitionOneList($query, $type, $date, $id,
                $cgModel->faculty_id,
                $cgModel->edu_level,
                $cgModel->special_right_id,
                $cgModel->financing_type_id,
                $cgModel->speciality_id,
                $cgModel->education_form_id,
                $cgModel->faculty->filial, $cgModel->ais_id);
        });
    }

    public function actionEntrantGraduateList($faculty, $speciality, $finance, $form, $type, $special = null, $date = null, $id = null)
    {
        /** @var \yii\caching\FileCache $competitionListCache */
        $competitionListCache = \Yii::$app->competitionListCache;
        $cacheKey = ['actionEntrantGraduateList', 'faculty' => $faculty, 'speciality' => $speciality, 'finance' => $finance, 'form' => $form, 'type' => $type, 'special' => $special, 'date' => $date, 'id' => $id, 'userId' => Yii::$app->user->id];

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

        if ($this->checkCompetitionOneListRedirect($query, $date)) {
            return $this->redirect('index');
        }

        return $competitionListCache->getOrSet($cacheKey, function () use ($special, $form, $faculty, $speciality, $finance, $type, $date, $id, $eduLevel, $query) {
            return $this->renderCompetitionOneList($query, $type, $date, $id,  $faculty, $eduLevel, $special, $finance, $speciality, $form);
        });
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

        $rCls = $query1->andWhere(['date' => $date ? $date : $dates[0]])->orderBy(['date'=> SORT_DESC])->all();
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

    private function checkCompetitionOneListRedirect($query, $date)
    {
        $dates = (clone $query)->select('date')->groupBy('date')->orderBy(['date'=>SORT_DESC])->column();

        if(!$dates) {
            return true;
        }


        if ($date && !preg_match('/[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])/', $date))
        {
            return true;
        }

        if(\Yii::$app->user->getIsGuest() ||  !\Yii::$app->user->can('entrant')) {
            if($date && ($dates[0] !== $date)){
                return true;
            }
        }

        return false;
    }
}