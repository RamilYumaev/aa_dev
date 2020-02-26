<?php
namespace modules\entrant\widgets\address;

use modules\entrant\models\Address;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class AddressWidget extends Widget
{
    public function run()
    {
        $query = Address::find()->where(['user_id' => \Yii::$app->user->identity->getId()]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
