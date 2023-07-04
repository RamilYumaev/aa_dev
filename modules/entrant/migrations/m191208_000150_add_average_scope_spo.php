<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000150_add_average_scope_spo extends Migration
{
    private function table() {
        return "average_scope_spo";
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'number_of_threes' => $this->smallInteger(2),
            'number_of_fours' => $this->smallInteger(2),
            'number_of_fives' => $this->smallInteger(2),
            'average' => $this->float()->null(),
        ], $tableOptions);


        $this->createIndex('{{%idx-average_scope_spo-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-average_scope_spo_user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
