<?php

namespace modules\entrant\widgets\individual;

use modules\entrant\models\UserIndividualAchievements;
use \yii\base\Widget;

class IndividualAchievementsWidget extends Widget
{

    public function run()
    {
        $model = UserIndividualAchievements::findAll(['user_id' => $this->getUser()]);
        return $this->render("index", ["model"=> $model]);
    }


    private function getUser()
    {
        return \Yii::$app->user->identity->getId();
    }


}