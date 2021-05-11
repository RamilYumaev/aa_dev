<?php
namespace modules\dictionary\migrations;
use modules\dictionary\models\RegisterCompetitionList;

use \yii\db\Migration;

class m191208_000062_alter_column_table_register_competition_lists extends Migration
{
    private function table() {
        return RegisterCompetitionList::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(),'error_message', $this->text());
    }
}
