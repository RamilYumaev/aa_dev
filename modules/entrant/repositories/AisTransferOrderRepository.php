<?php


namespace modules\entrant\repositories;
use modules\entrant\models\AisOrderTransfer;

class AisTransferOrderRepository
{
    public function get($id): AisOrderTransfer
    {
        if (!$model = AisOrderTransfer::findOne($id)) {
            throw new \DomainException('Приказ о зачислении не найден.');
        }
        return $model;
    }
}