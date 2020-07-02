<?php

namespace modules\entrant\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000080_add_columns_personal_entity extends Migration
{
    private function table()
    {
        return \modules\entrant\models\PersonalEntity::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),   'division_code', $this->string(7)->null()->comment("Код подразделения"));
    }

    public function down()
    {
    }
}
