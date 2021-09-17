<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AisOrderTransfer;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
use modules\exam\models\Exam;
use modules\exam\models\ExamAttempt;
class ResultExamRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant)
    {
        $this->jobEntrant = $jobEntrant;
    }

    public function readData()
    {
        $query = DictCompetitiveGroup::find()->distinct()->alias('cg')
            ->innerJoin(AisOrderTransfer::tableName(). ' as order','order.ais_cg=cg.ais_id')
            ->innerJoin(UserAis::tableName(). ' as user','user.incoming_id=order.incoming_id')
            ->innerJoin(DisciplineCompetitiveGroup::tableName().' as dcg', 'dcg.competitive_group_id=cg.id')
            ->innerJoin(Exam::tableName().' as ex', 'ex.discipline_id=dcg.discipline_id')
            ->innerJoin(ExamAttempt::tableName().' as ex_at', 'ex_at.exam_id=ex.id AND ex_at.user_id=user.user_id')
            ->currentYear('2020-2021')->foreignerStatus(0);
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