<?php

use \yii\db\Migration;

class m191208_000019_add_column_olympic extends Migration
{
    private function table() {
        return \olympic\models\OlimpicList::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'cg_no_visible', $this->integer(1)->defaultValue(0));

    }

    public function down()
    {
        $this->dropColumn($this->table(), 'cg_no_visible');
    }
}
