<?php

namespace modules\management\migrations;

use modules\management\models\CategoryDocument;
use modules\management\models\DictDepartment;
use modules\management\models\DictTask;
use modules\management\models\PostManagement;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use yii\db\Migration;

class m191208_001260_add_columns_registry_document extends Migration
{

    private function table()
    {
        return RegistryDocument::tableName();
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $this->addColumn($this->table(), 'access', $this->integer(1)->defaultValue(1));
        $this->addColumn($this->table(), 'user_id', $this->integer()->null());
        $this->addColumn($this->table(), 'dict_department_id', $this->integer()->null());
        $this->createIndex('{{%idx-registry_document-user_id}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-registry_document-user_id}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-registry_document-dict_department_id}}', $this->table(), 'dict_department_id');
        $this->addForeignKey('{{%fk-registry_document-dict_department_id}}', $this->table(), 'dict_department_id', DictDepartment::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }
}
