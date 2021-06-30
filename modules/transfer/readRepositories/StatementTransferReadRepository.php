<?php

namespace modules\transfer\readRepositories;

use modules\entrant\helpers\StatementHelper;
use modules\dictionary\models\JobEntrant;
use modules\transfer\models\PassExam;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;

class StatementTransferReadRepository
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
        $query = StatementTransfer::find();
        if ($this->jobEntrant->isTransferFok()) {
            $query->joinWith('passExam')->
            andWhere(['status' => StatementHelper::STATUS_ACCEPTED, 'faculty_id' => $this->jobEntrant->faculty_id])->andWhere(['is',
                'pass_exam.id', null]);
            return $query;
        }
        return  $query;
    }

    public function readDataExamPass($type = null)
    {
        $query = PassExam::find()->joinWith('statement');
        if($type) {
            $query->andWhere(['is_pass'=> $type]);
        }
            $query->andWhere(['status' => StatementHelper::STATUS_ACCEPTED, 'faculty_id' => $this->jobEntrant->faculty_id]);
            return $query;
    }
}