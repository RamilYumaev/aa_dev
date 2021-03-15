<?php

namespace modules\management\migrations;

use modules\management\models\CategoryDocument;
use modules\management\models\DictTask;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use yii\db\Migration;

class m191208_001257_add_table_registry_document extends Migration
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
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            "id" => $this->primaryKey(),
            "name" => $this->string(255)->notNull(),
            "category_document_id" =>  $this->integer()->notNull(),
            "link" => $this->string(255)->notNull()
        ], $tableOptions);

        $this->createIndex('{{%idx-registry-document-category_document_id}}', $this->table(), 'category_document_id');
        $this->addForeignKey('{{%fk-idx-egistry-document-category_document_id}}', $this->table(), 'category_document_id',
            CategoryDocument:: tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable($this->table());
    }
}
