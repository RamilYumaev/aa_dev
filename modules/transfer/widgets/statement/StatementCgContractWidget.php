<?php
namespace modules\transfer\widgets\statement;


use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use modules\transfer\models\PassExam;
use modules\transfer\models\StatementTransfer;
use yii\base\Widget;
use Yii;

class StatementCgContractWidget extends Widget
{
    public $userId;

    public function run()
    {
        $model = StatementTransfer::find()->joinWith('passExam')
            ->andWhere(['user_id' => $this->userId])
            ->andWhere(['finance' => DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT])
            ->andWhere(['success_exam' => PassExam::SUCCESS])
            ->all();
        return $this->render('index-contract', [
            'statements'=> $model,
        ]);
    }
}
