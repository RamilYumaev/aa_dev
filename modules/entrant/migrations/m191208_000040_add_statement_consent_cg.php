<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000040_add_statement_consent_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementConsentCg::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'statement_cg_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull(),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-statement_consent-statement_cg_id}}', $this->table(), 'statement_cg_id');
        $this->addForeignKey('{{%fk-statement_consent-statement_cg_id}}', $this->table(), 'statement_cg_id', StatementCg::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
