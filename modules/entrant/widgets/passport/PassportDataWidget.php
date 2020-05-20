<?php
namespace modules\entrant\widgets\passport;

use modules\entrant\models\PassportData;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PassportDataWidget extends Widget
{
    public $userId;
    public function run()
    {
        $query = PassportData::find()->where(['user_id' => $this->userId, 'main_status'=> false]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
