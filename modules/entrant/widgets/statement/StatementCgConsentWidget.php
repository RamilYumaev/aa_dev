<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementCgConsentWidget extends Widget
{
    public $userId;

    public function run()
    {
        $model = StatementCg::find()->joinWith('statement')->where(['user_id'=> $this->userId])->all();
        return $this->render('index-cg', [
            'statementsCg'=> $model,
        ]);
    }
}
