<?php
namespace modules\entrant\migrations;

use dictionary\models\Faculty;
use yii\db\Migration;

class m191208_000157_add_cg_2024_ss extends Migration
{
    private function table() {
        return "cg_2024_ss";
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'quid' => $this->string()->null(),
            'faculty_id' => $this->integer()->null(),
            'name' =>  $this->string()->null(),
            'code_spec' => $this->string(),
            'speciality' => $this->string(),
            'education_level' => $this->string(),
            'education_form' => $this->string(),
            'type' => $this->string(),
            'kcp' => $this->integer(),
            'profile' => $this->string(),
        ], $tableOptions);

        $this->createIndex('{{%idx-cg_2024_ss-education_level}}', $this->table(), 'education_level');
        $this->createIndex('{{%idx-cg_2024_ss-education_form}}', $this->table(), 'education_form');
        $this->createIndex('{{%idx-cg_2024_ss-speciality}}', $this->table(), 'speciality');
        $this->createIndex('{{%idx-cg_2024_ss-type}}', $this->table(), 'type');
        $this->createIndex('{{%idx-cg_2024_ss-profile}}', $this->table(), 'profile');
        $this->createIndex('{{%idx-cg_2024_ss-faculty_id}}', $this->table(), 'faculty_id');
        $this->addForeignKey('{{%fk-cg_2024_ss-faculty_id}}', $this->table(), 'faculty_id', Faculty::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
