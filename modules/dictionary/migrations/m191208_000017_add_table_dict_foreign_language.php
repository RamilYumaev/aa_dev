<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\DictForeignLanguage;
use \yii\db\Migration;

class m191208_000017_add_table_dict_foreign_language extends Migration
{
    private function table() {
        return DictForeignLanguage::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->null()->comment('Наименование'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
