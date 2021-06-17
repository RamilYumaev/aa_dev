<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000006_packet_document_user extends Migration
{
    private function table() {
        return 'packet_document_user';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer()->null(),
            'packet_document' => $this->integer(2)->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-packet_document_user-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-packet_document_user-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
