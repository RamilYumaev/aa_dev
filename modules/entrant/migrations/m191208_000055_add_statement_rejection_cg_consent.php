<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000055_add_statement_rejection_cg_consent extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementRejectionCgConsent::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_cg_consent_id' => $this->integer()->notNull(),
            'status_id' => $this->integer(1)->null(),
            'count_pages' => $this->integer()->defaultValue(0)
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_rejection-consent-statement_id}}', $this->table(), 'statement_cg_consent_id');
        $this->addForeignKey('{{%fk-idx-statement_rejection-consent-statement_id}}', $this->table(), 'statement_cg_consent_id', StatementConsentCg::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
