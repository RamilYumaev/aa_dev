<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementIaBackendWidget extends Widget
{
    public $statement;


    public function run()
    {
        return $this->render('index-ia-backend', [
            'statementIa'=> $this->statement,
        ]);
    }
}
