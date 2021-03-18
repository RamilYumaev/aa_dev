<?php
namespace modules\management\migrations;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictExaminer;
use modules\management\models\DictTask;
use modules\management\models\PostManagement;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use \yii\db\Migration;

class m191208_001261_add_primary_key_task_document extends Migration
{
    private function table() {
        return 'document_task';
    }

    public function up()
    {
        $this->addPrimaryKey('document_task-primary', $this->table(), ['document_registry_id', 'task_id']);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
