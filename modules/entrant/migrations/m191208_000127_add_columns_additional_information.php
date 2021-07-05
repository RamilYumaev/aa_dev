<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000127_add_columns_additional_information extends Migration
{
    private function table() {
        return AdditionalInformation::tableName();
    }

    public function up()
    {
       $this->addColumn($this->table(), 'is_epgu', $this->boolean()->defaultValue(false));
       $this->addColumn($this->table(), 'uid_epgu', $this->string(25)->defaultValue(''));
    }
}
