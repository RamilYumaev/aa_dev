<?php
namespace modules\entrant\migrations;

use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use \yii\db\Migration;

class m191208_000151_add_cg_ones extends Migration
{
    private function table() {
        return CompetitiveGroupOnes::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'average' => $this->float()->null(),
            'name' => $this->string(),
            'education_level' => $this->string(),
            'education_form' => $this->string(),
            'department' => $this->string(),
            'speciality' => $this->string(),
            'profile' => $this->string(),
            'type_competitive' => $this->string(),
            'quid' => $this->string()->null(),
            'status' => $this->integer(1)->defaultValue(0),
            'kcp' => $this->integer(3)->defaultValue(0),
            'kcp_transfer' => $this->integer(3)->defaultValue(0),
            'file_name' => $this->string()->null(),
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
