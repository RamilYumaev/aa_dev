<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000009_add_table_schedule_lessons_date extends Migration
{
    private function table() {
        return 'schedule_lessons_date';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id'=> $this->primaryKey(),
            'schedule_lessons_id'=> $this->integer()->notNull(),
            'teacher_id'=> $this->integer()->notNull(),
            'date'=>  $this->date()->notNull(),
            'text' => $this->text()
        ], $tableOptions);

        $this->createIndex('{{%idx-schedule_lessons_date-schedule_lessons_id}}', $this->table(), 'schedule_lessons_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_date-schedule_lessons_id}}', $this->table(), 'schedule_lessons_id', 'schedule_lessons', 'id',   'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-schedule_lessons_date-teacher_id}}', $this->table(), 'teacher_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_date-teacher_id}}', $this->table(), 'teacher_id', 'teacher', 'id',   'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
