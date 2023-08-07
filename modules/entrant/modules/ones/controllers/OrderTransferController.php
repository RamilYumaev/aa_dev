<?php
namespace modules\entrant\modules\ones\controllers;

use common\components\TbsWrapper;
use modules\entrant\modules\ones\forms\search\OrderTransferSearch;
use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use modules\entrant\modules\ones\model\CompetitiveList;
use modules\entrant\modules\ones\model\OrderTransferOnes;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderTransferController extends Controller
{
    public function behaviors(): array
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderTransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderTransferOnes();
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionOrder($id, $st)
    {
        $group = $this->findModel($id);
        if($group) {
            if($group->education_level == "Специалитет") {
                $st = 'spec'.$st;
            }
            $pathTemplate = Yii::getAlias("@modules/entrant/modules/ones/views/order-transfer/templates/".$st.".docx");
            if(file_get_contents($pathTemplate)) {
                $fileName =  ($st == "p" ? "Приказ" : "Сведения"). "(".$group->department." ".$group->education_form. " ".$group->education_level.").docx";
                $tbs = new TbsWrapper();
                $applicationsCommon = [];
                $tbs->openTemplate($pathTemplate);
                foreach (CompetitiveList::find()->joinWith('competitiveGroup')
                             ->andWhere([CompetitiveList::tableName().'.status' => CompetitiveList::STATUS_SUCCESS])
                    ->andWhere(['department' => $group->department])
                         ->andWhere(['education_form' => $group->education_form])
                             ->andWhere(['type_competitive' => $group->type_competitive])
                             ->andWhere(['education_level' => $group->education_level])
                             ->orderBy(['cg_id'=> SORT_ASC, 'fio'=> SORT_ASC])
                             ->all() as $application) {
                    {
                        $applicationsCommon[] = $application;
                    }
                }
                $orderSection = $this->prepareOrderSection($group);
                $blockData = $this->prepareBlock($applicationsCommon, $st == 's');
                if (\count($blockData['applications'])) {
                    $orderSection['blockOrder'][0]['block_app_normal'] = 1;
                }
                $tbs->merge('order', $orderSection['blockOrder']);
                $tbs->merge('applications', $blockData['applications']);

                $tbs->download($fileName);
            }else {
                $this->redirect('index');
            }
        }
    }

    /**
     * @param OrderTransferOnes $model
     * @return array
     */
    protected function prepareOrderSection(OrderTransferOnes $model)
    {
        $blockOrder = [];
        $blockOrder[0]['faculty'] = $model->department;

//        if ($model->education_level_id == StudentCompetitiveGroup::EDUCATION_LEVEL_BACHELOR ||
//            $model->education_level_id == StudentCompetitiveGroup::EDUCATION_LEVEL_BACHELOR_APPLIED
//        ) {
//
//        } elseif ($model->education_level_id == StudentCompetitiveGroup::EDUCATION_LEVEL_SPO) {
//            $blockOrder[0]['number_results'] = 'Средний балл аттестата, балл вступительного испытания, проводимого МПГУ';
//        } else {
//            $blockOrder[0]['number_results'] = 'Балл вступительного испытания, проводимого МПГУ';
//        }
//        if ($model->financing_type_id == StudentPersonal::FINANCING_TYPE_BUDGET) {
//            $blockOrder[0]['number_ia'] = 'Баллы за индивидуальные достижения';
//        } else {
//            $blockOrder[0]['number_ia'] = 'Номер договора';
//        }
        $blockOrder[0]['number_results'] = 'Балл Единого государственного экзамена (ЕГЭ), балл вступительного испытания, проводимого МПГУ (ВИ), балл Централизованного тестирования (ЦТ)';
        switch ($model->education_level) {
            case 'Бакалавриат':
                $blockOrder[0]['education_level'] = 'бакалавриата';
                break;
            case 'Специалитет':
                $blockOrder[0]['education_level'] = 'базового высшего образования';
                break;
        }
        switch ($model->education_form) {
            case "Очная форма обучения":
                $blockOrder[0]['education_form'] = 'очную';
                break;
            case "Очно-заочная форма обучения":
                $blockOrder[0]['education_form'] = 'очно-заочную';
                break;
            case "Заочная форма обучения":
                $blockOrder[0]['education_form'] = 'заочную';
                break;
        }

        $blockOrder[0]['protocol_date'] = "08.08.2023";
        $blockOrder[0]['protocol_number'] = 8;


//        $blockOrder[0]['if_magister'] =
//            $model->education_level_id == StudentCompetitiveGroup::EDUCATION_LEVEL_MAGISTER ?
//                ' для продолжения обучения ' : '';
        $blockOrder[0]['kcp'] = 'в рамках контрольных цифр приема';

        $blockOfficial = [];
        $blockOfficial[0]['printer_name'] = "";
        $blockOfficial[0]['printer_position'] = "";
        $blockOfficial[0]['phone'] = "" ;

        return [
            'blockOrder' => $blockOrder,
            'blockOfficial' => $blockOfficial,
        ];
    }

    protected function prepareBlock($competitiveLists, $anonymity)
    {
        $numBlock = -1;
        $numApplication = 0;
        $blockApplications = [];
        $currentSpecialty = '';
        $currentSpecialization = '';

        /* @var  $currentApplication CompetitiveList
         */
        foreach ($competitiveLists as $currentApplication) {
            $currentCG = $currentApplication->competitiveGroup;

            $currentBlock = [];
            if ($currentSpecialty !== $currentCG->speciality
                || $currentSpecialization !== $currentCG->profile
            ) {
                $currentSpecialty = $currentCG->speciality;
                $currentSpecialization = $currentCG->profile;
                ++$numBlock;
                $numApplication = 0;

                $currentBlock['specialty'] = $currentSpecialty;
                $currentBlock['specialization'] = $currentSpecialization;
            }

            $currentBlock['table'][$numApplication] = [];
            $currentBlock['table'][$numApplication]['num'] = ($numApplication + 1) . '.';
            if ($anonymity) {
                $currentBlock['table'][$numApplication]['snils_or_id'] = $currentApplication->snils_or_id;
            } else {
                $currentBlock['table'][$numApplication]['full_name'] =
                    $currentApplication->fio;
            }

            $currentBlock['table'][$numApplication]['mark'] = $currentApplication->sum_ball;

            $currentBlock['table'][$numApplication]['results'] = $currentApplication->subjectMarks;

            $currentBlock['table'][$numApplication]['contract_number'] = '';
            $currentBlock['table'][$numApplication]['ia'] = $currentApplication->mark_ai;
            if (isset($currentBlock['specialty'])) {
                $blockApplications[$numBlock]['specialty'] = $currentBlock['specialty'];
                $blockApplications[$numBlock]['specialization'] = $currentBlock['specialization'];
            }
            $blockApplications[$numBlock]['table'][$numApplication] = $currentBlock['table'][$numApplication];

            ++$numApplication;
        }

        return [
            'applications' => $blockApplications,
        ];
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

//    /**
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException
//     * @throws \yii\db\StaleObjectException
//     */
//    public function actionDelete($id)
//    {
//        $model = $this->findModel($id);
//        $model->delete();
//        return $this->redirect(['index']);
//    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OrderTransferOnes
    {
        if (($model = OrderTransferOnes::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}
