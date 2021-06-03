<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000004_statement_transfer_ extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer()->null(),
            'status' => $this->integer(1)->notNull(),
            'type' => $this->integer(1)->notNull(),
            'count_pages'=> $this->integer()->defaultValue(0)->comment("количество страниц"),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-statement_transfer-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-statement_transfer-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
