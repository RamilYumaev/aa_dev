<?php
namespace modules\management\migrations;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictExaminer;
use modules\management\models\DictTask;
use modules\management\models\PostManagement;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use \yii\db\Migration;

class m191208_001259_add_table_task_document extends Migration
{
    private function table() {
        return 'document_task';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'document_registry_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-document_task-document_registry_id}}', $this->table(), 'document_registry_id');
        $this->addForeignKey('{{%fk-idx-document_task-document_registry_id}}', $this->table(),
            'document_registry_id', RegistryDocument::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-document_task-task_id}}', $this->table(), 'task_id');
        $this->addForeignKey('{{%fk-document_task-task_id}}', $this->table(), 'task_id', Task::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }



    public function down()
    {
        $this->dropTable($this->table());
    }
}
