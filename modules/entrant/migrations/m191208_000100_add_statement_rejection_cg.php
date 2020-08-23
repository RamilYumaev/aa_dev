<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000100_add_statement_rejection_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementRejectionRecord::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'cg_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'count_pages' => $this->integer()->defaultValue(0),
            'order_name' => $this->string()->notNull(),
            'order_date' => $this->date()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_rr-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-statement_rr-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-statement_rr-cg_id}}', $this->table(), 'cg_id');
        $this->addForeignKey('{{%fk-idx-statement_rr-cg_id}}', $this->table(), 'cg_id', DictCompetitiveGroup::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
