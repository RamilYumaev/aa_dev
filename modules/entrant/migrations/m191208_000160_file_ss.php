<?php
namespace modules\entrant\migrations;

use modules\entrant\modules\ones_2024\model\FileSS;
use yii\db\Migration;

class m191208_000160_file_ss extends Migration
{
    private function table() {
        return FileSS::tableName();
    }
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'file_name' => $this->string(),
            "created_at" =>  $this->integer()->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
