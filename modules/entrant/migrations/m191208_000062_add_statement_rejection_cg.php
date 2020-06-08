<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000062_add_statement_rejection_cg extends Migration
{
    private function table() {
        return 'statement_rejection_cg';
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

        $this->createIndex('{{%idx-statement_rejection_cg-statement_cg}}', $this->table(), 'statement_cg');
        $this->addForeignKey('{{%fk-statement_rejection_cg-statement_cg}}', $this->table(), 'statement_cg',
            StatementCg::tableName(),
            'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
