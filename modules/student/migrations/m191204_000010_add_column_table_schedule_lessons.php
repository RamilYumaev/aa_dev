<?php
namespace modules\student\migrations;

use \yii\db\Migration;

class m191204_000010_add_column_table_schedule_lessons extends Migration
{
    private function table() {
        return 'schedule_lessons';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'type_line', $this->integer(1)->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
