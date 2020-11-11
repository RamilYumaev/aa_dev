<?php

use \yii\db\Migration;

class m191208_000020_drop_column_olympic extends Migration
{
    private function table() {
        return \olympic\models\Olympic::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'cg_no_visible');

    }

    public function down()
    {
         $this->addColumn($this->table(), 'cg_no_visible', $this->integer(1)->defaultValue(0));
    }
}
