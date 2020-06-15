<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191208_000065_add_columns_ia extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementIa::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "message", $this->string()->null());
    }

    public function down()
    {

    }
}
