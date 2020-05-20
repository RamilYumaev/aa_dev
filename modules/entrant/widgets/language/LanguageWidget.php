<?php
namespace modules\entrant\widgets\language;

use modules\entrant\models\Address;
use modules\entrant\models\Language;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class LanguageWidget extends Widget
{
    public $userId;
    public function run()
    {
        $query = Language::find()->where(['user_id' => $this->userId]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'userId' => $this->userId
        ]);
    }

}
