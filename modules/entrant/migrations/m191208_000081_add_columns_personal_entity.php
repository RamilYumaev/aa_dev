<?php

namespace modules\entrant\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000081_add_columns_personal_entity extends Migration
{
    private function table()
    {
        return \modules\entrant\models\PersonalEntity::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(),   'fio');
    }

    public function down()
    {
    }
}
