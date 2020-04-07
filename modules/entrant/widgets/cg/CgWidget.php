<?php
namespace modules\entrant\widgets\cg;

use modules\entrant\models\UserCg;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CgWidget extends Widget
{
    public function run()
    {
        $query = UserCg::find()->where(['user_id' => \Yii::$app->user->identity->getId()]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
