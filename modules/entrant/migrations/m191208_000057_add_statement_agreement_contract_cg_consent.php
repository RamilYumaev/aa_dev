<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000057_add_statement_agreement_contract_cg_consent extends Migration
{
    private function table() {
        return 'statement_agreement_contract_cg';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_cg' => $this->integer()->notNull(),
            'status_id' => $this->integer(1)->null(),
            'count_pages' => $this->integer()->defaultValue(0),
            'created_at'=> $this->integer()->notNull(),
            'updated_at'=> $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_agreement_contract_cg-statement_cg}}', $this->table(), 'statement_cg');
        $this->addForeignKey('{{%fk-statement_agreement_contract_cg-statement_cg}}', $this->table(), 'statement_cg', StatementCg::tableName(),
            'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
