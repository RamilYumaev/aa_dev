<?php

namespace modules\entrant\widgets\individual;

use modules\entrant\models\UserIndividualAchievements;
use \yii\base\Widget;

class IndividualAchievementsWidget extends Widget
{
    public $userId;

    public function run()
    {
        $model = UserIndividualAchievements::findAll(['user_id' => $this->userId]);
        return $this->render("index", ["model"=> $model]);
    }


}