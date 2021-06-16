<?php
namespace modules\transfer\migrations;

use \yii\db\Migration;

class m191305_000001_add_transfer_ extends Migration
{
    private function table() {
        return 'transfer_mpgu';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->smallInteger(1)->notNull(),
            'number'=> $this->string()->defaultValue(''),
            'current_status' => $this->integer(2)->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('{{%idx-transfer_mpgu-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-transfer_mpgu-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
