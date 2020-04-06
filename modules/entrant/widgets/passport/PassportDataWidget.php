<?php
namespace modules\entrant\widgets\passport;

use modules\entrant\models\PassportData;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PassportDataWidget extends Widget
{
    public function run()
    {
        $query = PassportData::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->orderBy(['main_status'=> SORT_DESC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
