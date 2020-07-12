<?php
namespace modules\dictionary\migrations;
use \yii\db\Migration;

class m191208_000038_add_table_examiner extends Migration
{
    private function table() {
        return 'dict_examiner';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
