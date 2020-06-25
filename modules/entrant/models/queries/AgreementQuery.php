<?php
namespace modules\entrant\models\queries;

use modules\entrant\helpers\StatementHelper;

class AgreementQuery extends \yii\db\ActiveQuery
{
    public function status($status)
    {
        return $this->andWhere(["status_id" => $status]);
    }





}