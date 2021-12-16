<?php

namespace modules\transfer\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191305_000034_add_columns_legal_entity extends Migration
{
    private function table()
    {
        return "legal_entity_transfer";
    }

    public function up()
    {
        $this->addColumn($this->table(), "surname", $this->string()->null()->comment("Фамилия"));
        $this->addColumn($this->table(), 'first_name', $this->string()->null()->comment("Имя"));
        $this->addColumn($this->table(), "patronymic", $this->string()->null()->comment("Отчество"));
        $this->addColumn($this->table(), "bank", $this->string()->null()->comment("Отделение банка"));

    }

    public function down()
    {
    }
}
