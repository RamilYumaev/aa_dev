<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000053_add_statement_rejection extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementRejection::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_id' => $this->integer()->notNull(),
            'status_id' => $this->integer(1)->null(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_rejection-statement_id}}', $this->table(), 'statement_id');
        $this->addForeignKey('{{%fk-idx-statement_rejection-statement_id}}', $this->table(), 'statement_id', Statement::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
