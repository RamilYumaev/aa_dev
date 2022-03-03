<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000003_user_persons extends Migration
{
    private function table() {
        return 'user_persons_literature';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'persons_literature_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('user_persons_literature-primary', $this->table(), ['persons_literature_id', 'user_id']);
        $this->addForeignKey('{{%fk-idx-idx-literature-olympic-persons_literature_id}}', $this->table(), 'persons_literature_id', 'persons_literature', 'id',  'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-idx-idx-literature-olympic-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
