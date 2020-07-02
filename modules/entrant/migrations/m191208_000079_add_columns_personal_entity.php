<?php

namespace modules\entrant\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000079_add_columns_personal_entity extends Migration
{
    private function table()
    {
        return \modules\entrant\models\PersonalEntity::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "surname", $this->string()->null()->comment("Фамилия"));
        $this->addColumn($this->table(), 'name', $this->string()->null()->comment("Имя"));
        $this->addColumn($this->table(), "patronymic", $this->string()->null()->comment("Отчество"));
    }

    public function down()
    {
    }
}
