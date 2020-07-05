<?php
namespace modules\entrant\readRepositories;
use modules\entrant\models\ReceiptContract;

class ReceiptReadRepository
{
    public function readData() {
        $query = ReceiptContract::find();
        return $query;
    }
}