<?php
namespace modules\entrant\widgets\profile;

use olympic\models\auth\Profiles;
use yii\base\Widget;

class ProfileWidget extends Widget
{
    public function run()
    {
        $model = Profiles::findOne(['user_id' => \Yii::$app->user->identity->getId()]);
        return $this->render('index', [
            'profile'=> $model
        ]);
    }
}
