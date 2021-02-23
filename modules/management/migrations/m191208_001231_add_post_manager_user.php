<?php
namespace modules\management\migrations;
use common\auth\models\User;

use modules\management\models\PostManagement;
use \yii\db\Migration;

class m191208_001231_add_post_manager_user extends Migration
{
    private function table() {
        return 'management_user';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'post_management_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-management_user-post_management_id}}', $this->table(), 'post_management_id');
        $this->addForeignKey('{{%fk-idx-management_user-post_management_id}}', $this->table(),
            'post_management_id', PostManagement::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-management_user-user_id}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-management_user-user_id}}', $this->table(), 'user_id', User::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }



    public function down()
    {
        $this->dropTable($this->table());
    }
}
