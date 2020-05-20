<?php
namespace modules\entrant\widgets\address;

use modules\entrant\models\Address;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class AddressWidget extends Widget
{
    public $userId;

    public function run()
    {
        $query = Address::find()->where(['user_id' => $this->userId]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        return $this->render('index', [
            'userId' => $this->userId,
            'dataProvider' => $dataProvider,
        ]);
    }

}
