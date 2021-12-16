<?php

namespace modules\transfer\migrations;
use common\auth\models\User;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191305_000025_add_receipt extends Migration
{
    private function table() {
        return 'receipt_contract_transfer';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'contract_cg_id' => $this->integer()->notNull(),
            'period'=> $this->integer(1)->notNull(),
            'count_pages' => $this->integer()->defaultValue(0),
            'created_at'=> $this->integer()->notNull(),
            'updated_at'=> $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-receipt_contract_transfer-contract_cg_id}}', $this->table(), 'contract_cg_id');
        $this->addForeignKey('{{%fk-receipt_contract_transfer-contract_cg_id}}',
            $this->table(), 'contract_cg_id', 'statement_agreement_contract_transfer_cg',
            'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
