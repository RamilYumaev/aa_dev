<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000026_add_cse_vi_select extends Migration
{
    private function table() {
        return \modules\entrant\models\CseViSelect::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'result_cse' => $this->text()->null()->comment('Результаты EГЭ'),
            'vi' => $this->text()->null()->comment("Вступительные испытания"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-cse_vi_select-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-cse_vi_select-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
