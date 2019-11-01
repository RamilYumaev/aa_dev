<?php

use \yii\db\Migration;
use \olympic\models\Olympic;
use \yii\db\Query;

class m190124_110203_table_olympic_update_column_status extends Migration
{
    protected $columnStatus = "current_status";

    protected function table() {
        return Olympic::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), $this->columnStatus, $this->smallInteger(1)->defaultValue(0));

        $rows = (new Query())->select([$this->columnStatus])->from($this->table())->all();

        foreach ($rows as $row) {
            $this->update($this->table(), [$this->columnStatus => 0]);
        }

        $this->renameColumn($this->table(), $this->columnStatus, "status");

    }

    public function down()
    {
        echo "";
    }
}
