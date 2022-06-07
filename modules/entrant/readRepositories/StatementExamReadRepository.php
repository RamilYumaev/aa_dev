<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use dictionary\models\DisciplineCompetitiveGroup;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\UserDiscipline;

class StatementExamReadRepository
{
    private $jobEntrant;
    private $exam;

    public function __construct(JobEntrant $jobEntrant, $exam = 'vi')
    {
        $this->exam = $exam;
        $this->jobEntrant = $jobEntrant;
    }

    public function readData()
    {
        $query = Statement::find();
        $query->innerJoin(StatementCg::tableName(), 'statement_cg.statement_id=statement.id');
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');
        $query->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=statement_cg.cg_id');
        $query->andWhere(['statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
            'statement.form_category' => DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_1,
            'statement.status' => StatementHelper::STATUS_WALT]);
        if ($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
            $query->andWhere('anketa.user_id NOT IN (SELECT user_id FROM statement WHERE special_right IN (1,2,4))');
        }

        if ($this->jobEntrant->isCategoryTarget()) {
            $query->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
            $query->andWhere('anketa.user_id  IN (SELECT user_id FROM agreement)');
            $query->orWhere('anketa.user_id IN (SELECT user_id FROM other_document WHERE exemption_id = 4)');
        }

        if ($this->jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
            $query->innerJoin(OtherDocument::tableName(), 'other_document.user_id=anketa.user_id');
            $query->andWhere(['or', ['not in', 'exemption_id', [null, 4]], ['anketa.category_id' => CategoryStruct::WITHOUT_COMPETITION]]);
        }

        if (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }
        if($this->exam == 'vi') {
            $query->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.competitive_group_id=dict_competitive_group.id')
                ->innerJoin(DictDiscipline::tableName(), 'dict_discipline.id=discipline_competitive_group.discipline_id')
                ->andWhere(['dict_discipline.is_och'=> true]);
        }else  {
            $query->innerJoin(DisciplineCompetitiveGroup::tableName(), 'discipline_competitive_group.competitive_group_id=dict_competitive_group.id')
                ->innerJoin(UserDiscipline::tableName(), 'discipline_user.user_id=statement.user_id AND 
                discipline_user.discipline_id=discipline_competitive_group.discipline_id')
            ->andWhere(['discipline_user.type'=>[UserDiscipline::CSE_VI, UserDiscipline::CT_VI, UserDiscipline::VI]]);
        }

        return $query->distinct();
    }
}