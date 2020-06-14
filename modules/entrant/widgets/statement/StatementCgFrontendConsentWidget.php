<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementCgFrontendConsentWidget extends Widget
{
    public $userId;

    public function run()
    {
        $query = StatementConsentCg::find()
            ->alias('consent')
            ->statusNoDraft('consent.')
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = consent.statement_cg_id')
            ->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id')
            ->andWhere(['statement.user_id' => $this->userId]);
        $model = clone $query;

        $isAcceptedOrRecall = $query->andWhere(['consent.status' => [StatementHelper::STATUS_ACCEPTED]])->exists();
        return $this->render('index-cg-consent-frontend', [
            'statementConsents'=> $model->orderByCreatedAtDesc()->all(),
            'isAcceptedOrRecall' => $isAcceptedOrRecall,
        ]);
    }
}
