<?php

namespace modules\transfer\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191305_000038_add_columns_personal_entity extends Migration
{
    private function table()
    {
        return 'personal_entity_transfer';
    }

    public function up()
    {
        $this->dropColumn($this->table(),   'fio');
    }

    public function down()
    {
    }
}
