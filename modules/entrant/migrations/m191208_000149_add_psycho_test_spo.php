<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000149_add_psycho_test_spo extends Migration
{
    private function table() {
        return "psycho_test_spo";
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex('{{%idx-psycho_test_spo}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-psycho_test_spo}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
