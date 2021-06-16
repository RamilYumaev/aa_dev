<?php

namespace modules\transfer\controllers\frontend;

use dictionary\models\DictCompetitiveGroup;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\CurrentEducationInfo;
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
            var_dump($data);
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('course', ['cg'=> $model]);
    }


    protected function findModel() {
        return CurrentEducationInfo::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
