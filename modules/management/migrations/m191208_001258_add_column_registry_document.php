<?php

namespace modules\management\migrations;

use modules\management\models\CategoryDocument;
use modules\management\models\DictTask;
use modules\management\models\RegistryDocument;
use modules\management\models\Task;
use yii\db\Migration;

class m191208_001258_add_column_registry_document extends Migration
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
        $this->addColumn($this->table(), 'file', $this->string()->null());

    }}
