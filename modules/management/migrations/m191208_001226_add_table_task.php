<?php

namespace modules\management\migrations;

use modules\management\models\DictTask;
use modules\management\models\Task;
use yii\db\Migration;

class m191208_001226_add_table_task extends Migration
{

    private function table()
    {
        return Task::tableName();
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            "id" => $this->primaryKey(),
            "title" => $this->string(255)->notNull(),
            "text" => $this->text(),
            'dict_task_id' =>  $this->integer(11)->notNull(),
            'director_user_id' =>  $this->integer(11)->notNull(),
            'position' => $this->integer(11)->notNull()->defaultValue(0),
            'date_end' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-task-user}}', $this->table(), 'director_user_id');
        $this->addForeignKey('{{%fk-idx-task-user}}', $this->table(), 'director_user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-task-dict_task_id}}', $this->table(), 'dict_task_id');
        $this->addForeignKey('{{%fk-idx-task-dict_task_id}}', $this->table(), 'dict_task_id', DictTask::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable($this->table());
    }
}
