<?php
namespace modules\entrant\widgets\statement;


use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementCgContractWidget extends Widget
{
    public $userId;

    public function run()
    {
        $model = StatementCg::find()
            ->joinWith('statement')
            ->joinWith('cg')
            ->innerJoin(StatementConsentCg::tableName(), 'statement_consent_cg.statement_cg_id=statement_cg.id')
            ->andwhere(['user_id' => $this->userId,
                'financing_type_id' => DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT,
                'statement.status' => StatementHelper::STATUS_ACCEPTED,
                'statement_consent_cg.status' => StatementHelper::STATUS_ACCEPTED, ])
            ->all();
        return $this->render('index-contract', [
            'statementsCg'=> $model,
        ]);
    }
}
