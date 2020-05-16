<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191208_000045_add_columns_statement extends Migration
{
    private function table() {
        return \modules\entrant\models\Statement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "created_at", $this->integer()->notNull());
        $this->addColumn($this->table(), "updated_at", $this->integer()->notNull());
        $this->addColumn($this->table(), "message", $this->string()->null());
    }

    public function down()
    {

    }
}
