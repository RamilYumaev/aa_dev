<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000062_add_columns_statement_rejection extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementRejection::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "created_at", $this->integer()->notNull());
        $this->addColumn($this->table(), "updated_at", $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'created_at');
        $this->dropColumn($this->table(), 'updated_at');
    }
}
