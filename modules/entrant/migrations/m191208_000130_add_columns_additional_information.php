<?php

namespace modules\entrant\migrations;
use modules\entrant\models\AdditionalInformation;
use \yii\db\Migration;

class m191208_000130_add_columns_additional_information extends Migration
{
    private function table() {
        return AdditionalInformation::tableName();
    }

    public function up()
    {
       $this->addColumn($this->table(), 'is_time', $this->boolean()->defaultValue(0));
    }
}
