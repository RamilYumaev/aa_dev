<?php
namespace modules\management\migrations;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictExaminer;
use modules\management\models\DictTask;
use modules\management\models\PostManagement;
use \yii\db\Migration;

class m191208_001237_drop_post_manager_task extends Migration
{
    private function table() {
        return 'management_task';
    }

    public function up()
    {
        $this->dropTable('management_task');
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'post_rate_id' => $this->integer()->notNull(),
            'dict_task_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-management_task-post_rate_id}}', $this->table(), 'post_rate_id');
        $this->addForeignKey('{{%fk-idx-management_task-post_rate_id}}', $this->table(),
            'post_rate_id', 'post_rate_department', 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-management_task-dict_task_id}}', $this->table(), 'dict_task_id');
        $this->addForeignKey('{{%fk-management_task-dict_task_id}}', $this->table(), 'dict_task_id', DictTask::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }



    public function down()
    {
        $this->dropTable($this->table());
    }
}
