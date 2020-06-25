<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
class AgreementReadRepository
{
    public function readData() {
        $query = Agreement::find()->alias('agreement')
            ->innerJoin(Statement::tableName(), 'statement.user_id =
        agreement.user_id')->andWhere(['>', 'status', StatementHelper::STATUS_DRAFT]);
        return $query;
    }
}