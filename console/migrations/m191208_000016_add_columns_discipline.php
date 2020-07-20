<?php

use \yii\db\Migration;

class  m191208_000016_add_columns_discipline extends Migration
{
    private function table() {
        return \dictionary\models\DictDiscipline::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_och', $this->integer(1)->defaultValue(0));

    }

    public function down()
    {
        echo "";
    }
}
