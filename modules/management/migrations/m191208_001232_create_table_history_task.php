<?php

namespace modules\management\migrations;
use common\auth\models\User;
use modules\management\models\Task;
use yii\db\Migration;

class m191208_001232_create_table_history_task extends Migration
{
    private function table() {
        return 'history_task';
    }
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            $this->table(),
            [
                'id' => $this->primaryKey(),
                'task_id' => $this->integer(11),
                'before' => $this->json(),
                'after' => $this->json(),
                'created_by' => $this->integer(11),
                'created_at' => $this->dateTime()->notNull(),
            ],
            $options
        );

        $this->createIndex('{{%idx-history_task-task_id}}', $this->table(), 'task_id');
        $this->addForeignKey('{{%fk-idx-history_task-task_id}}', $this->table(),
            'task_id', Task::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-history_task-created_by}}', $this->table(), 'created_by');
        $this->addForeignKey('{{%fk-history_task-created_by}}', $this->table(), 'created_by', User::tableName(),
            'id', 'CASCADE', 'RESTRICT');
        
    }

    public function safeDown()
    {
        $this->dropTable($this->table());
    }
}
