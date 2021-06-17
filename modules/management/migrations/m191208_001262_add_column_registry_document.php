<?php

namespace modules\management\migrations;

use modules\management\models\RegistryDocument;
use yii\db\Migration;

class m191208_001262_add_column_registry_document extends Migration
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
        $this->addColumn($this->table(), 'is_deleted', $this->boolean()->defaultValue(false));
    }
}
