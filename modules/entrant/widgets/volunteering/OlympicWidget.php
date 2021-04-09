<?php
namespace modules\entrant\widgets\volunteering;

use modules\entrant\models\Language;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class OlympicWidget extends Widget
{
    public $userId;
    public function run()
    {
        $query = Language::find()->where(['user_id' => $this->userId]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render($this->view, [
            'dataProvider' => $dataProvider,
            'userId' => $this->userId
        ]);
    }

}
