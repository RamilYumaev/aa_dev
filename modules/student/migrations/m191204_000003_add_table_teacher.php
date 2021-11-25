<?php
namespace modules\student\migrations;

use dictionary\models\Faculty;
use \yii\db\Migration;

class m191204_000003_add_table_teacher extends Migration
{
    private function table() {
        return 'teacher';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'isActive' => $this->boolean()->defaultValue(true)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
