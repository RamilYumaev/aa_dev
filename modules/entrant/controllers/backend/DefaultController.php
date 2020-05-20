<?php

namespace modules\entrant\controllers\backend;

use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\searches\ProfilesStatementSearch;
use olympic\models\auth\Profiles;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ProfilesStatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFull($user)
    {
        $profile = $this->findModel($user);
        return $this->render('full', [
            'profile' => $profile
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Profiles
    {
        if (($model = Profiles::find()
            ->alias('profiles')
            ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
            ->andWhere(['>','statement.status', StatementHelper::STATUS_DRAFT])
                ->andWhere(['profiles.user_id' => $id])->one()
            ) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}
