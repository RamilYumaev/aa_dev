<?php


namespace modules\entrant\repositories;


use modules\entrant\models\LegalEntity;
use modules\entrant\models\ReceiptContract;
use modules\usecase\RepositoryDeleteSaveClass;

class ReceiptContractRepository extends RepositoryDeleteSaveClass
{
    public function getId($id): ?ReceiptContract
    {
        return ReceiptContract::findOne($id);
    }

}