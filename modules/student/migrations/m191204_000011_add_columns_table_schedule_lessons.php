<?php
namespace modules\student\migrations;

use \yii\db\Migration;

class m191204_000011_add_columns_table_schedule_lessons extends Migration
{
    private function table() {
        return 'schedule_lessons';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'date_begin', $this->date()->notNull()->defaultValue('2021-09-01'));
        $this->addColumn($this->table(), 'date_end', $this->date()->notNull()->defaultValue('2021-12-30'));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
