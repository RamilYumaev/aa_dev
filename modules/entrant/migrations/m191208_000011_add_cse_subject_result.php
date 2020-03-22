<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000011_add_cse_subject_result extends Migration
{
    private function table() {
        return \modules\entrant\models\CseSubjectResult::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'result' => $this->text()->null()->comment('Результаты EГЭ'),
            'year' => $this->string()->null()->comment("Год сдачи ЕГЭ"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-cse_subject_result-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-cse_subject_result-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
