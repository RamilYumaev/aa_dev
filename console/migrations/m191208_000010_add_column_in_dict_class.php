<?php

use \yii\db\Migration;

class m191208_000010_add_column_in_dict_class extends Migration
{
    private function table() {
        return \dictionary\models\DictClass::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'sort_id', $this->integer()->null()->comment('Сортировка'));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'sort_id');
    }
}
