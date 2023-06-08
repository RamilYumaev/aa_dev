<?php

namespace modules\dictionary\migrations;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Talons;
use \yii\db\Migration;

class m200332_104171_add_columns_talons extends Migration
{
    private function table() {
        return Talons::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'anketa_id', $this->integer()->null());
        $this->addColumn($this->table(), 'entrant_id', $this->integer()->null());
    }
}
