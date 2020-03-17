<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000008_add_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->tinyInteger(3)->null()->comment('Тип документа'),
            'note' => $this->string()->null()->comment('Примечание'),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-other_document-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-other_document-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-other_document-type}}', $this->table(), 'type');
        $this->addForeignKey('{{%fk-idx-other_document-type}}', $this->table(), 'type', \modules\entrant\models\dictionary\DictIncomingDocumentType::tableName(),
            'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
