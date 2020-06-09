<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\StatementIndividualAchievements;
use yii\base\Widget;
use Yii;

class StatementIaFrontendWidget extends Widget
{
    public $userId;


    public function run()
    {
        $model = StatementIndividualAchievements::find()->user($this->userId)->all();
        return $this->render('index-ia-frontend', [
            'statementsIa'=> $model,
        ]);
    }
}
