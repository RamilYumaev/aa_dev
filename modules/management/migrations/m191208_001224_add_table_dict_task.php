<?php

namespace modules\management\migrations;

use modules\management\models\DictTask;
use yii\db\Migration;

class m191208_001224_add_table_dict_task extends Migration
{

    private function table()
    {
        return DictTask::tableName();
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {

        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            "id" => $this->primaryKey(),
            "name" => $this->text()->notNull()->comment("Наименование функции")
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
