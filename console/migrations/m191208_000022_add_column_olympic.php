<?php

use \yii\db\Migration;

class m191208_000022_add_column_olympic extends Migration
{
    private function table() {
        return \olympic\models\OlimpicList::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'disabled_a', $this->boolean()->defaultValue(false));

    }

    public function down()
    {
        $this->dropColumn($this->table(), 'disabled_a');
    }
}
