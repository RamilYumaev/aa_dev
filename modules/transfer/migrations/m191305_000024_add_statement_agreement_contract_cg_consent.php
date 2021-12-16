<?php

namespace modules\transfer\migrations;
use modules\entrant\models\StatementCg;
use modules\transfer\models\StatementTransfer;
use \yii\db\Migration;

class m191305_000024_add_statement_agreement_contract_cg_consent extends Migration
{
    private function table() {
        return 'statement_agreement_contract_transfer_cg';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_transfer_id' => $this->integer()->notNull(),
            'status_id' => $this->integer(1)->defaultValue(0),
            'count_pages' => $this->integer()->defaultValue(0),
            'created_at'=> $this->integer()->notNull(),
            'updated_at'=> $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_agreement_contract_cg_transfer-statement_cg}}', $this->table(), 'statement_transfer_id');
        $this->addForeignKey('{{%fk-statement_agreement_contract_cg_transfer-statement_cg}}', $this->table(), 'statement_transfer_id', StatementTransfer::tableName(),
            'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
