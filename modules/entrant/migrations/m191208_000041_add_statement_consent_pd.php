<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use \yii\db\Migration;

class m191208_000041_add_statement_consent_pd extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementConsentPersonalData::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);
        
        $this->createIndex('{{%idx-statement_consent_pd-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-statement_consent_pf-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
