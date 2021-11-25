<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000006_add_table_discipline_education_faculty extends Migration
{
    private function table() {
        return 'discipline_education_faculty';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'dict_faculty_id' => $this->integer()->notNull(),
            'discipline_education_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('discipline_education_faculty-primary', $this->table(), ['discipline_education_id', 'dict_faculty_id']);

        $this->createIndex('{{%idx-discipline_education_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id');
        $this->addForeignKey('{{%fk-dx-discipline_education_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id', Faculty::tableName(), 'id',   'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-discipline_education_faculty-discipline_education_id}}', $this->table(), 'discipline_education_id');
        $this->addForeignKey('{{%fk-dx-discipline_education_faculty-discipline_education_id}}', $this->table(), 'discipline_education_id', 'discipline_education', 'id',   'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
