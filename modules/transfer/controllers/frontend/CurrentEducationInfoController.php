<?php

namespace modules\transfer\controllers\frontend;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\helpers\ConverterFaculty;
use modules\transfer\models\CurrentEducation;
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

        $searchModel = new CompetitiveGroupSearch($this->getCurrentFinanceArray(), $this->getEduLevelArray());
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
        $statement = $this->statement();
        $model = DictCompetitiveGroup::find()
            ->specialRight(null)
            ->andWhere(['id' => $id])
            ->andWhere(['not in', 'year', "2022-2023"])
            ->andWhere(['is_unavailable_transfer' => false])
            ->foreignerStatus(0)
            ->eduLevel($this->getEduLevelArray())
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
                    $model->financing_type_id,
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
                $statement->finance = $model->financing_type_id;
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
        return $this->isFinanceContract() ? [DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT,] :
            !$this->getStartBudget() ? [DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT] : [DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT,
            DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET];
    }

    public function getCurrentEduLevelGraduateArray() {
        return [DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL];
    }

    public function getEnd() {
        return strtotime("2023-08-20 15:00:00") < strtotime(\date("Y-m-d G:i:s"));
    }

    public function getStartBudget() {
        return strtotime("2023-06-18 00:00:01") < strtotime(\date("Y-m-d G:i:s")) &&  strtotime("2023-07-15 15:00:00") >  strtotime(\date("Y-m-d G:i:s")) ;
    }

    public function getStartGraduate() {
        return strtotime("2023-02-01 10:00:00") < strtotime(\date("Y-m-d G:i:s")) &&  strtotime("2023-03-07 15:00:00") > strtotime(\date("Y-m-d G:i:s"));
    }

    public function getEduLevelArray() {
        $array = [DictCompetitiveGroupHelper::EDUCATION_LEVEL_SPO,
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
            DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER,
        ];
        if($this->getStartGraduate()) {
            $array[] = DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL;
        }

        if($this->getEnd()) {
            array_splice($array, 0, 3);
        }

        return $array;
    }


    protected function findModel() {
        return CurrentEducation::findOne(['user_id'=> $this->getUser()]);
    }

    protected function isFinanceContract() {
       $transfer = TransferMpgu::findOne(['user_id'=> $this->getUser()]);
        if ($transfer && $transfer->isMpgu()) {
            $data= $transfer->getJsonData();
            return $data['finance'] == DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT;
        } else {
            if($model = $this->findModel()){
                return $model->finance == DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT;
            }
        }
        return false;
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
