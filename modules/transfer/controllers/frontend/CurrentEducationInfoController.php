<?php

namespace modules\transfer\controllers\frontend;

use dictionary\models\DictCompetitiveGroup;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\CurrentEducationInfo;
use modules\transfer\models\StatementTransfer;
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
        $searchModel = new CompetitiveGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
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
            ->tpgu(0)->one();
        if(!$model) {
            throw new NotFoundHttpException("Не найдена конкурсная группа");
        }
        if ($data = Yii::$app->request->post()) {
            if(!$statement) {
                StatementTransfer::create($this->getUser(), 5, $model->id, $data['course'],  $data['edu_count'])->save();
            }else {
                if($statement->countFiles()) {
                    \Yii::$app->session->setFlash('warning',  'Редактирование невозможно, пока в системе имеется сканированная копия документа, содержащая эти данные');
                    return $this->redirect(['post-document/index']);
                }
                $statement->course = $data['course'];
                $statement->edu_count = $data['edu_count'];
                $statement->cg_id = $model->id;
                $statement->save();
            }

            return $this->redirect(['post-document/index']);
        }
        return $this->renderAjax('course', ['cg'=> $model]);
    }

    protected function statement() {
        return StatementTransfer::findOne(['user_id' => $this->getUser()]);
    }

    protected function findModel() {
        return CurrentEducationInfo::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}