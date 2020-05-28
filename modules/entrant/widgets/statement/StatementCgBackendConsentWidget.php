<?php
namespace modules\entrant\widgets\statement;


use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\services\StatementIndividualAchievementsService;
use modules\entrant\services\StatementService;
use yii\base\Widget;
use Yii;

class StatementCgBackendConsentWidget extends Widget
{
    public $statementId;

    public function run()
    {
        $model = StatementConsentCg::find()
            ->alias('consent')
            ->statusNoDraft('consent.')
            ->orderByCreatedAtDesc()
            ->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = consent.statement_cg_id')
            ->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id')
            ->where(['statement.id' => $this->statementId])
            ->all();
        ;
        return $this->render('index-cg-backend', [
            'statementConsents'=> $model,
        ]);
    }
}
