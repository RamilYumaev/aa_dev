<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000001_add_table_group_faculty extends Migration
{
    private function table() {
        return 'group_faculty';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'dict_faculty_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'year_education' => $this->string(10)->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-group_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id');
        $this->addForeignKey('{{%fk-dx-group_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id', Faculty::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
