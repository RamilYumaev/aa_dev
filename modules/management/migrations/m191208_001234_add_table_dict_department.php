<?php
namespace modules\management\migrations;

use modules\management\models\DictDepartment;
use \yii\db\Migration;

class m191208_001234_add_table_dict_department extends Migration
{
    private function table() {
        return DictDepartment::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
