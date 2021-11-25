<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000004_add_table_teacher_faculty extends Migration
{
    private function table() {
        return 'teacher_faculty';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'dict_faculty_id' => $this->integer()->notNull(),
            'teacher_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('teacher_faculty-primary', $this->table(), ['teacher_id', 'dict_faculty_id']);

        $this->createIndex('{{%idx-teacher_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id');
        $this->addForeignKey('{{%fk-dx-teacher_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id', Faculty::tableName(), 'id',   'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-teacher_faculty-teacher_id}}', $this->table(), 'teacher_id');
        $this->addForeignKey('{{%fk-dx-teacher_faculty-teacher_id}}', $this->table(), 'teacher_id', 'teacher', 'id',   'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
