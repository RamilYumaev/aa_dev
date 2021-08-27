<?php
namespace modules\entrant\migrations;

use dictionary\models\DictCompetitiveGroup;
use \yii\db\Migration;

class m191208_000131_add_event extends Migration
{
    private function table() {
        return 'event';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'cg_id' => $this->integer()->notNull(),
            'date' => $this->dateTime()->null(),
            'type' => $this->integer()->notNull(),
            'place'=> $this->string()->null(),
            'name_src' => $this->string()->null(),
            'src' => $this->string()->null(),
        ], $tableOptions);
        $this->addForeignKey("fk-cg-key", $this->table(), "cg_id",
            DictCompetitiveGroup::tableName(), "id", "CASCADE", "CASCADE");
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
