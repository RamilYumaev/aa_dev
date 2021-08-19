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
        $query->joinWith('passExam')->andWhere(['is', 'pass_exam.id', null]);
        if ($this->jobEntrant->isTransferFok()) {
            $query->andWhere(['status' => StatementHelper::STATUS_ACCEPTED, 'faculty_id' => $this->jobEntrant->faculty_id]);
            return $query;
        }
        return  $query;
    }

    public function readDataExamPass($type = null, $isProtocol = null)
    {
        $query = PassExam::find()->joinWith('statement');
        if($type) {
            $query->andWhere(['is_pass'=> $type]);
        }
        if(!is_null($isProtocol)) {
            $query->andWhere(['is_protocol'=> $isProtocol]);
        }
        $query->andWhere(['status' => StatementHelper::STATUS_ACCEPTED]);
        if ($this->jobEntrant->isTransferFok()) {
            $query->andWhere(['faculty_id' => $this->jobEntrant->faculty_id]);
        }
        return $query;
    }
}