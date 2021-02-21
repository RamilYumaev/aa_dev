<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001247_add_table_day_off extends Migration
{
    private function table() {
        return 'date_off';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'schedule_id' => $this->integer()->notNull(),
            'date' => $this->date()->null(),
            'isAllowed' => $this->boolean()->defaultValue(0),
            'note' => $this->text(),


        ], $tableOptions);

        $this->createIndex('{{%idx-date_off-schedule_id}}', $this->table(), 'schedule_id');
        $this->addForeignKey('{{%fk-idx-date_off-schedule_id}}', $this->table(), 'schedule_id', Schedule::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
