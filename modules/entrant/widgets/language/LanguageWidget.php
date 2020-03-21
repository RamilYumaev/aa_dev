<?php
namespace modules\entrant\widgets\language;

use modules\entrant\models\Address;
use modules\entrant\models\Language;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class LanguageWidget extends Widget
{
    public function run()
    {
        $query = Language::find()->where(['user_id' => \Yii::$app->user->identity->getId()]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
