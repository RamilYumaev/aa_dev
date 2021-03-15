<?php

namespace modules\management\migrations;

use modules\management\models\CategoryDocument;
use yii\db\Migration;

class m191208_001256_add_table_category_document extends Migration
{

    private function table()
    {
        return CategoryDocument::tableName();
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {

        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            "id" => $this->primaryKey(),
            "name" => $this->text()->notNull()->comment("Наименование")
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable($this->table());
    }
}
