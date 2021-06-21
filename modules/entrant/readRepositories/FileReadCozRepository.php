<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\File;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PreemptiveRight;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
use modules\entrant\services\StatementAgreementContractCgService;
use olympic\models\auth\Profiles;

class FileReadCozRepository
{
    private $jobEntrant;
    private $isID;

    public function __construct(JobEntrant $jobEntrant = null)
    {
        if ($jobEntrant) {
            $this->jobEntrant = $jobEntrant;
        }
    }

    public function readData()
    {
        $query = File::find()->alias('files');
        $query->andWhere(['files.model'=> FileHelper::listModelsCOZ()]);
        $query->innerJoin(Statement::tableName(), 'statement.user_id=files.user_id');
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=files.user_id');
        $query->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT]);
        $query->andWhere('files.user_id NOT IN (SELECT user_id FROM user_ais)');
        $query->andWhere(['not in', 'anketa.category_id', [
            CategoryStruct::COMPATRIOT_COMPETITION, CategoryStruct::GOV_LINE_COMPETITION,
            CategoryStruct::FOREIGNER_CONTRACT_COMPETITION,
            CategoryStruct::WITHOUT_COMPETITION]]);
        $query->andWhere(['not in', 'statement.special_right', [DictCompetitiveGroupHelper::SPECIAL_RIGHT,
            DictCompetitiveGroupHelper::TARGET_PLACE]]);
        $query->andWhere(['citizenship_id' => DictCountryHelper::RUSSIA]);
        $query->andWhere(['not in', 'anketa.user_id', PreemptiveRight::find()
            ->joinWith('otherDocument')->select("other_document.user_id")
            ->indexBy("other_document.user_id")->column()]);
        $query->distinct();
        return $query;
    }

}