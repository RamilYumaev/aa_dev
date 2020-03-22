<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\DictCseSubject;
use \yii\db\Migration;

class m191208_000019_add_table_dict_cse_subject extends Migration
{
    private function table() {
        return DictCseSubject::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('Наименование'),
            'min_mark' => $this->integer(3)->null()->comment('Минимальный балл для поступления'),
            'composite_discipline_status' => $this->integer(1)->defaultValue(0)->comment('Составная дисциплина'),
            'cse_status' => $this->integer(1)->defaultValue(0)->comment('Предмет ЕГЭ'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
