<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000012_add_statement_consent_pd extends Migration
{
    private function table() {
        return \modules\transfer\models\StatementConsentPersonalData::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'count_pages' => $this->integer()->defaultValue(0)->comment("количество страниц")

        ], $tableOptions);
        
        $this->createIndex('{{%idx-statement_consent_pd_t-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-statement_consent_pf_t-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
