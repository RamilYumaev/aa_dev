<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\DictPostEducation;
use \yii\db\Migration;

class m191208_000015_add_table_dict_post_education extends Migration
{
    private function table() {
        return DictPostEducation::tableName();
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
