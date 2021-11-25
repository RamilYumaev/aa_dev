<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000008_add_table_schedule_lessons_teacher extends Migration
{
    private function table() {
        return 'schedule_lessons_teacher';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'schedule_lessons_id'=> $this->integer()->notNull(),
            'teacher_id'=> $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('schedule_lessons_teacher-primary-key', $this->table(), ['schedule_lessons_id', 'teacher_id']);

        $this->createIndex('{{%idx-schedule_lessons_teacher-schedule_lessons_id}}', $this->table(), 'schedule_lessons_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_teacher-schedule_lessons_id}}', $this->table(), 'schedule_lessons_id', 'schedule_lessons', 'id',   'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-schedule_lessons_teacher-teacher_id}}', $this->table(), 'teacher_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_teacher-teacher_id}}', $this->table(), 'teacher_id', 'teacher', 'id',   'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
