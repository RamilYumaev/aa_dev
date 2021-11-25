<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000002_add_table_audience_faculty extends Migration
{
    private function table() {
        return 'audience_faculty';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'dict_faculty_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-audience_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id');
        $this->addForeignKey('{{%fk-dx-audience_faculty-dict_faculty_id}}', $this->table(), 'dict_faculty_id', Faculty::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
