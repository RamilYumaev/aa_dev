<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000012_add_submitted_documents extends Migration
{
    private function table() {
        return \modules\entrant\models\SubmittedDocuments::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'user_id' => $this->integer()->notNull()->unique(),
            'type' => $this->integer(1)->null()->comment("Способ подачи"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-submitted_documents-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-submitted_documents-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
