<?php
namespace modules\management\migrations;

use modules\management\models\PostManagement;
use \yii\db\Migration;

class m191208_001229_add_table_post_management extends Migration
{
    private function table() {
        return PostManagement::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'name_short' => $this->string()->notNull(),
            'is_director' => $this->string()->notNull(),
        ], $tableOptions);


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
