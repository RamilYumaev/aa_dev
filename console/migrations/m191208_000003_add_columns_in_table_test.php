<?php

use \yii\db\Migration;

class m191208_000003_add_columns_in_table_test extends Migration
{
    private function table() {
        return \testing\models\Test::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'random_order', $this->integer(1)->defaultValue(1)->null()->comment("Случайный порядок вопросов"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'random_order');
    }
}
