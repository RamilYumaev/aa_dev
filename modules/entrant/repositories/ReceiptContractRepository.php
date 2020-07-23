<?php


namespace modules\entrant\repositories;


use modules\entrant\models\ReceiptContract;
use modules\usecase\RepositoryDeleteSaveClass;

class ReceiptContractRepository extends RepositoryDeleteSaveClass
{
    public function getId($id): ?ReceiptContract
    {
        return ReceiptContract::findOne($id);
    }

    public function isExitsContract($contractId): ?ReceiptContract
    {
        return ReceiptContract::findOne(['contract_cg_id'=>$contractId]);
    }

}