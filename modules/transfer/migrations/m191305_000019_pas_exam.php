<?php
namespace modules\transfer\migrations;

use modules\transfer\models\StatementTransfer;
use \yii\db\Migration;

class m191305_000019_pas_exam extends Migration
{
    private function table() {
        return 'pass_exam';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'is_pass'=>$this->integer(1),
            'statement_id' => $this->integer()->notNull(),
            'message' => $this->string()->null(),
            'agree' => $this->boolean(),
        ], $tableOptions);

        $this->createIndex('{{%idx-pass_exam-statement}}', $this->table(), 'statement_id');
        $this->addForeignKey('{{%fx-pass_exam-statement}}', $this->table(), 'statement_id', StatementTransfer::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
