<?php

namespace modules\entrant\readRepositories;

use Codeception\Lib\Di;
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

class ProfileFileReadRepository
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
        $query = Profiles::find()->alias('profiles');
        $query->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id');
        $query->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT]);
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=profiles.user_id');
        $query->andWhere('profiles.user_id NOT IN (SELECT user_id FROM user_ais)');
        $query->andWhere(['not in', 'anketa.category_id', [CategoryStruct::TARGET_COMPETITION,
        CategoryStruct::COMPATRIOT_COMPETITION, CategoryStruct::GOV_LINE_COMPETITION,
        CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::SPECIAL_RIGHT_COMPETITION,
        CategoryStruct::WITHOUT_COMPETITION]]);
        $query->andWhere(['citizenship_id' => DictCountryHelper::RUSSIA]);
        $query->andWhere(['not in', 'anketa.user_id', PreemptiveRight::find()
                ->joinWith('otherDocument')->select("other_document.user_id")
                ->indexBy("other_document.user_id")->column()]);
        $query->innerJoin(File::tableName(), 'files.user_id=profiles.user_id');
        $query->andWhere(['files.model'=> FileHelper::listModelsCOZ()]);
        $query->select(['profiles.user_id', 'files.status',  'last_name', 'first_name', 'patronymic', 'gender', 'country_id', 'region_id', 'phone']);
        $query->andWhere(['files.status' => FileHelper::STATUS_NO_ACCEPTED]);
        $query->orderBy(['profiles.user_id' => SORT_DESC]);
        $query->distinct();
        return $query;
    }

}