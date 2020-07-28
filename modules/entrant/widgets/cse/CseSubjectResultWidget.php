<?php
namespace modules\entrant\widgets\cse;

use modules\entrant\models\CseSubjectResult;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class CseSubjectResultWidget extends Widget
{
    public $userId;
    public function run()
    {
        $query = CseSubjectResult::find()->where(['user_id' => $this->userId])->orderBy(['year'=> SORT_ASC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'userId' => $this->userId
        ]);
    }

}
