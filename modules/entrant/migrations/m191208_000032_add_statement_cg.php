<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000032_add_statement_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementCg::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_id' => $this->integer()->notNull(),
            'cg_id' => $this->integer()->notNull(),
            'status_id' => $this->integer(1)->null(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_cg-statement_id}}', $this->table(), 'statement_id');
        $this->addForeignKey('{{%fk-idx-statement_cg-statement_id}}', $this->table(), 'statement_id', Statement::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-statement_cg-cg_id}}', $this->table(), 'cg_id');
        $this->addForeignKey('{{%fk-idx-statement_cg-cg_id}}', $this->table(), 'cg_id', DictCompetitiveGroup::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
