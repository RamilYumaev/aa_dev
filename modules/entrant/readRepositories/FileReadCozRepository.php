<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
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

    public function __construct(JobEntrant $jobEntrant = null)
    {
        if ($jobEntrant) {
            $this->jobEntrant = $jobEntrant;
        }
    }

    public function readData()
    {
        $query = File::find()->alias('files');
        $query->innerJoin(Statement::tableName(), 'statement.user_id=files.user_id');
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=files.user_id');
        $query->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT]);
        $query->andWhere(['files.status' => FileHelper::STATUS_WALT]);
        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
            $query->andWhere('files.user_id NOT IN (SELECT user_id FROM statement WHERE special_right IN (1,2))');
            $query->andWhere(['citizenship_id' => DictCountryHelper::RUSSIA]);
            $query->andWhere(['files.model'=> FileHelper::listModelsFok()]);
        } elseif($this->jobEntrant->isCategoryTarget()){
            $query->innerJoin(Agreement::tableName(), 'agreement.user_id=anketa.user_id');
            $query->andWhere(['files.model'=> FileHelper::listModelsTarget()]);
            $query->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
        } else {
            $query->andWhere(['not in', 'anketa.category_id', [CategoryStruct::TARGET_COMPETITION,
                CategoryStruct::COMPATRIOT_COMPETITION, CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::SPECIAL_RIGHT_COMPETITION,
                CategoryStruct::WITHOUT_COMPETITION]]);
            $query->andWhere(['citizenship_id' => DictCountryHelper::RUSSIA]);
            $query->andWhere(['not in', 'anketa.user_id', PreemptiveRight::find()
                ->joinWith('otherDocument')->select("other_document.user_id")
                ->indexBy("other_document.user_id")->column()]);
            $query->andWhere(['files.model'=> FileHelper::listModelsCOZ()]);
        }
        $query->distinct();
        return $query;
    }
}