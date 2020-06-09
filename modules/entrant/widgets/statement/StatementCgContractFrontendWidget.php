<?php
namespace modules\entrant\widgets\statement;


use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementCgContractFrontendWidget extends Widget
{
    public $userId;

    public function run()
    {
        $model = StatementAgreementContractCg::find()->statementUser($this->userId)->all();
        return $this->render('index-contract-frontend', [
            'contracts'=> $model,
        ]);
    }
}
