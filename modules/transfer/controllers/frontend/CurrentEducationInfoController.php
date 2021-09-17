<?php

namespace modules\transfer\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\helpers\ConverterFaculty;
use modules\transfer\models\CurrentEducationInfo;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;
use modules\transfer\search\CompetitiveGroupSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CurrentEducationInfoController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class'=> TransferRedirectBehavior::class,
                'ids'=>['index' ]
            ]
        ];
    }

    public function actionIndex() {
        ini_set('max_execution_time', 300);
        if($this->findTransfer()->inMpgu()) {
            \Yii::$app->session->setFlash('warning', 'Страница недоступна');
            return $this->redirect(['default/index']);
        }

        $searchModel = new CompetitiveGroupSearch($this->getCurrentFinanceArray(), $this->getCurrentEduLevelArray());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    protected function findTransfer() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */

    public function actionSelect($id)
    {
        $currentYear = Date("Y");
        $statement = $this->statement();
        $lastYear = $currentYear - 1;
        $model = DictCompetitiveGroup::find()
            ->specialRight(null)
            ->andWhere(['id' => $id])
            ->andWhere(['not in', 'year', "$lastYear-$currentYear"])
            ->foreignerStatus(0)
            ->eduLevel($this->getCurrentEduLevelArray())
            ->finance($this->getCurrentFinanceArray())
            ->tpgu(0)->one();
        if(!$model) {
            throw new NotFoundHttpException("Не найдена конкурсная группа");
        }
        if ($data = Yii::$app->request->post()) {
            if($data['semester'] &&  $data['edu_count']  && $data['semester']) {
                $faculty = ConverterFaculty::searchFaculty($model->faculty_id);
            if(!$statement) {
                StatementTransfer::create($this->getUser(), $data['edu_count'], $faculty, $model->id,
                    $data['semester'],
                    $data['course'])->save();
            }else {
                if($statement->countFiles()) {
                    \Yii::$app->session->setFlash('warning',  'Редактирование невозможно, пока в системе имеется сканированная копия документа, содержащая эти данные');
                    return $this->redirect(['post-document/index']);
                }
                $statement->course = $data['course'];
                $statement->semester = $data['semester'];
                $statement->edu_count = $data['edu_count'];
                $statement->cg_id = $model->id;
                $statement->faculty_id = $faculty;
                $statement->save();
                }
            return $this->redirect(['post-document/index']);
            }else {
                \Yii::$app->session->setFlash('warning',  'Не введены все данные');
                return $this->redirect(['index']);
            }
        }
        return $this->renderAjax('course', ['cg'=> $model]);
    }

    protected function statement() {
        return StatementTransfer::findOne(['user_id' => $this->getUser()]);
    }

    public function getCurrentFinanceArray() {
        return [DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT,
            DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET];
    }

    public function getCurrentEduLevelArray() {
        return [DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL];
    }

    protected function findModel() {
        return CurrentEducationInfo::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
