<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;

class ResultExamRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant)
    {
        $this->jobEntrant = $jobEntrant;
    }

    public function readData()
    {
        $query = DictCompetitiveGroup::find()->currentYear('2019-2020')
            ->finance(DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET);
        if ($this->jobEntrant->isCategoryFOK()) {
            $query->faculty($this->jobEntrant->faculty_id)
                ->eduLevel([DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]);
        }

        if ($this->jobEntrant->isCategoryGraduate()) {
            $query->eduLevel(DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL);
        }

        if (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
            $query->faculty($this->jobEntrant->category_id);
        }

        return $query;
    }
}