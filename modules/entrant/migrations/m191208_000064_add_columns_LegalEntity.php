<?php

namespace modules\entrant\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000064_add_columns_LegalEntity extends Migration
{
    private function table()
    {
        return \modules\entrant\models\LegalEntity::tableName();
    }

    public function up()
    {
        $this->renameColumn($this->table(), "bank", "bik");
        $this->addColumn($this->table(), "p_c", $this->string("25")->notNull());
        $this->addColumn($this->table(), "k_c", $this->string("25")->notNull());
    }

    public function down()
    {
        $this->renameColumn($this->table(), "bik", "bank");
        $this->dropColumn($this->table(), 'p_c');
        $this->dropColumn($this->table(), 'k_c');
    }
}
