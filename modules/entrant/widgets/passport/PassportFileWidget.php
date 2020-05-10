<?php
namespace modules\entrant\widgets\passport;

use modules\entrant\models\PassportData;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PassportFileWidget extends Widget
{
    public function run()
    {
        $model = PassportData::findOne(['user_id' => \Yii::$app->user->identity->getId(), 'main_status'=> true]);
        return $this->render('file', [
            'model' => $model
        ]);
    }

}
