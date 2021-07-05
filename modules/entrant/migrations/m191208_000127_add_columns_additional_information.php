<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000106_add_columns_additional_information extends Migration
{
    private function table() {
        return AdditionalInformation::tableName();
    }

    public function up()
    {
       $this->addColumn($this->table(), 'return_doc', $this->integer(1)->defaultValue(3));
       $this->addColumn($this->table(), 'is_military_edu', $this->boolean()->defaultValue(false));
    }
}
