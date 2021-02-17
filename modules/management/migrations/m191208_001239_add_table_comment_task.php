<?php

namespace modules\management\migrations;

use common\auth\models\User;
use modules\management\models\Task;
use yii\db\Migration;

class m191208_001239_add_table_comment_task extends Migration
{

    private function table()
    {
        return 'comment_task';
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable(
            $this->table(),
            [
                'id' => $this->primaryKey(),
                'task_id' => $this->integer(11),
                'text' => $this->text()->null(),
                'created_by' => $this->integer(11),
                'created_at' => $this->dateTime()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('{{%idx-comment_task-task_id}}', $this->table(), 'task_id');
        $this->addForeignKey('{{%fk-idx-comment_task-task_id}}', $this->table(),
            'task_id', Task::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-comment_task-created_by}}', $this->table(), 'created_by');
        $this->addForeignKey('{{%fk-comment_task-created_by}}', $this->table(), 'created_by', User::tableName(),
            'id', 'CASCADE', 'RESTRICT');
        
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable($this->table());
    }
}
