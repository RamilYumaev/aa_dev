<?php

use \yii\db\Migration;

class m190124_110228_add_column_olympic_in_table_question extends Migration
{

    private function table() {
        return \testing\models\TestQuestion::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'olympic_id', $this->integer()->defaultValue(0)->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'olympic_id');
    }
}
