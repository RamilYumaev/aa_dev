<?php
namespace modules\entrant\widgets\profile;

use olympic\models\auth\Profiles;
use yii\base\Widget;

class ProfileWidget extends Widget
{
    public function run()
    {
        $model = Profiles::find()->where(['user_id' => \Yii::$app->user->identity->getId()])->one();
        return $this->render('index', [
            'profile'=> $model
        ]);
    }
}
