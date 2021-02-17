<?php
namespace modules\management\migrations;

use modules\management\models\DictTask;
use \yii\db\Migration;

class m191208_001244_add_columns_dict_task extends Migration
{
    private function table() {
        return DictTask::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'name');
        $this->addColumn($this->table(), 'name', $this->text());
        $this->addColumn($this->table(), 'name_short', $this->string()->defaultValue(''));
    }

}
