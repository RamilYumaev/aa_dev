<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000107_add_columns_anketa extends Migration
{
    private function table() {
        return Anketa::tableName();
    }

    public function up()
    {
       $this->addColumn($this->table(), 'speciality_spo', $this->integer()->null()->defaultValue(null));
    }
}
