<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000013_add_ecp extends Migration
{
    private function table() {
        return \modules\entrant\models\ECP::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->integer(2)->null()->comment("Тип ЭЦП"),
            'file_name' => $this->string()->null()->comment("Файл")
        ], $tableOptions);
        
        $this->createIndex('{{%idx-ecp-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-ecp-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
