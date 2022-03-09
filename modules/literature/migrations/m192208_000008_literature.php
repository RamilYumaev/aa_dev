<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000008_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->truncateTable($this->table());
        $this->alterColumn($this->table(),'date_issue', $this->date()->notNull());
        $this->alterColumn($this->table(),'full_name', $this->string()->defaultValue(''));
        $this->alterColumn($this->table(),'short_name', $this->string()->defaultValue(''));
        $this->alterColumn($this->table(),'status_olympic', $this->integer(1)->null());
        $this->alterColumn($this->table(), 'mark_olympic', $this->string(5)->null());
        $this->alterColumn($this->table(), 'grade_number', $this->integer(2)->null());
        $this->alterColumn($this->table(), 'grade_performs', $this->integer(2)->null());
        $this->alterColumn($this->table(),'fio_teacher', $this->string()->defaultValue(''));
        $this->alterColumn($this->table(),'place_work', $this->string()->defaultValue(''));
        $this->alterColumn($this->table(),'post', $this->string()->defaultValue(''));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
