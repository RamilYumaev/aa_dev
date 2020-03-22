<?php
namespace modules\entrant\widgets\cse;

use modules\entrant\models\CseSubjectResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CseSubjectResultWidget extends Widget
{
    public function run()
    {
        $query = CseSubjectResult::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->orderBy(['year'=> SORT_ASC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
