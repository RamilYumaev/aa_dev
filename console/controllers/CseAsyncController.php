<?php
namespace console\controllers;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\jobs\CseAsyncJob;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\entrant\models\UserDiscipline;
use olympic\models\auth\Profiles;
use yii\console\Controller;

class CseAsyncController extends Controller
{
    public function actionIndex()
    {
       $model = Profiles::find()->select('profiles.user_id')
            ->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id')
            ->innerJoin(Statement::tableName(), 'statement.user_id=user_ais.user_id')
            ->innerJoin(UserDiscipline::tableName(), 'discipline_user.user_id=statement.user_id')
            ->andWhere(['statement.status'=> StatementHelper::STATUS_ACCEPTED])
            ->andWhere(['statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR])
            ->orderBy(['statement.user_id' => SORT_DESC])->groupBy('profiles.user_id')->all();
        /**
         * @var  Profiles $item
         */
        foreach ($model as $item) {
            \Yii::$app->queue->push(new CseAsyncJob(['profile' => $item]));
        }
       echo "окей";
    }
}