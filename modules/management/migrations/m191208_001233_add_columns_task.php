<?php
namespace modules\management\migrations;

use modules\management\models\Task;
use \yii\db\Migration;

class m191208_001233_add_columns_task extends Migration
{
    private function table() {
        return Task::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'note', $this->string()->defaultValue(''));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'note');
    }
}
