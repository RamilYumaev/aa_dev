<?php

namespace modules\transfer\readRepositories;

use modules\entrant\helpers\StatementHelper;
use modules\dictionary\models\JobEntrant;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;

class TransferReadRepository
{
    private $jobEntrant;
    private $type;

    public function __construct($type, JobEntrant $jobEntrant = null)
    {
        if ($jobEntrant) {
            $this->jobEntrant = $jobEntrant;
        }
        $this->type = $type;
    }

    public function readData()
    {
        $query = $this->profileDefaultQuery();
        if($this->type) {
            $query->andWhere(['type'=>  $this->type]);
        }
        if ($this->jobEntrant->isTransferFok()) {
            $query->innerJoin(StatementTransfer::tableName(), 'statement_transfer.user_id=transfer_mpgu.user_id')
            ->andWhere(['status' => StatementHelper::STATUS_ACCEPTED, 'faculty_id' => $this->jobEntrant->faculty_id ]);
            return $query;
        }
        return  $query;
    }

    public function profileDefaultQuery()
    {
        return TransferMpgu::find();
    }
}