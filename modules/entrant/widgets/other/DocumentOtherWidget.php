<?php
namespace modules\entrant\widgets\other;

use modules\entrant\models\Address;
use modules\entrant\models\OtherDocument;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\mutex\OracleMutex;

class DocumentOtherWidget extends Widget
{
    public function run()
    {
        $query = OtherDocument::find()->where(['user_id' => \Yii::$app->user->identity->getId()]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
