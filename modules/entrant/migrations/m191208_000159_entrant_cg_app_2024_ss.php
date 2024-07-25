<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000159_entrant_cg_app_2024_ss extends Migration
{
    private function table() {
        return "entrant_cg_app_2024_ss";
    }
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'quid_statement' => $this->string()->null(),
            'quid_cg' => $this->string()->null(),
            'quid_profile' => $this->string()->null(),
            'quid_cg_competitive' => $this->string()->null(),
            'priority_vuz' => $this->integer()->null(),
            'priority_ss' => $this->integer()->null(),
            'actual' => $this->string()->null(),
            'source' => $this->string()->null(),
            'status' => $this->string()->null(),
            'is_el_original' => $this->boolean(),
            'is_paper_original' => $this->boolean(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
