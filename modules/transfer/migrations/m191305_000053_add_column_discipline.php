<?php

namespace modules\transfer\migrations;
use dictionary\models\DictDiscipline;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191305_000053_add_column_discipline extends Migration
{
    private function table() {
        return DictDiscipline::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'faculty_id', $this->integer()->null());
        $this->createIndex('{{%idx-discipline-faculty_id}}', $this->table(), 'faculty_id');
        $this->addForeignKey('{{%fk-discipline-faculty_id}}', $this->table(), 'faculty_id', Faculty::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }
}
