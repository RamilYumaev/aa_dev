<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191208_000031_add_columns_statement extends Migration
{
    private function table() {
        return \modules\entrant\models\Statement::tableName();
    }

    public function up()
    {
        $this->renameColumn($this->table(), 'submitted', 'status');
    }

    public function down()
    {
        $this->renameColumn($this->table(), 'status', 'submitted');
    }
}
