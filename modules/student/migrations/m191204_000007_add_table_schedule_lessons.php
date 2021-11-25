<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000007_add_table_schedule_lessons extends Migration
{
    private function table() {
        return 'schedule_lessons';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'year_education' => $this->string(10)->notNull(),
            //'dict_faculty_id' => $this->integer()->notNull(),
            'day_week' => $this->integer(1)->notNull(),
            'semester' => $this->integer(1)->notNull(),
            'group_faculty_id' => $this->integer()->notNull(),
            'number_pair' => $this->integer(1)->notNull(),
            'discipline_education_id' => $this->integer()->notNull(),
            'form' => $this->integer(1)->notNull(),
            'type_class' => $this->integer(1)->notNull(),
            'audience_faculty_id' => $this->integer()->null(),
            'type_group' => $this->integer(1)->notNull(),
        ], $tableOptions);


        $this->createIndex('{{%idx-schedule_lessons-group_faculty_id}}', $this->table(), 'group_faculty_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_faculty-group_faculty_id}}', $this->table(), 'group_faculty_id', 'group_faculty', 'id',   'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-schedule_lessons-discipline_education_id}}', $this->table(), 'discipline_education_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_faculty-discipline_education_id}}', $this->table(), 'discipline_education_id', 'discipline_education', 'id',   'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-schedule_lessons-audience_faculty_id}}', $this->table(), 'audience_faculty_id');
        $this->addForeignKey('{{%fk-dx-schedule_lessons_faculty-audience_faculty_id}}', $this->table(), 'audience_faculty_id', 'audience_faculty', 'id',   'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
