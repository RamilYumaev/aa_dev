<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000028_rename_columns_special_right extends Migration
{
    private function table() {
        return \modules\entrant\models\Statement::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(),'special_right', $this->integer(1)->null());
    }

    public function down()
    {
        $this->alterColumn($this->table(),'special_right', $this->integer(1)->notNull());
    }
}
