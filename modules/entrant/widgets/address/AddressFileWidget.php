<?php
namespace modules\entrant\widgets\address;

use modules\entrant\helpers\AddressHelper;
use modules\entrant\models\Address;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class AddressFileWidget extends Widget
{
    public function run()
    {
        $model = Address::find()->where(['user_id' => \Yii::$app->user->identity->getId(), 'type' => [AddressHelper::TYPE_REGISTRATION, AddressHelper::TYPE_RESIDENCE]])->all();
        return $this->render('file', [
            'addresses' => $model,
        ]);
    }

}
