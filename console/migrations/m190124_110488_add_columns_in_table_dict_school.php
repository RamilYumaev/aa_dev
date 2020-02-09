<?php

use \yii\db\Migration;

class m190124_110488_add_columns_in_table_dict_school extends Migration
{
    private function table() {
        return \dictionary\models\DictSchools::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'email', $this->string());
        $this->addColumn($this->table(), 'status', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'email');
        $this->dropColumn($this->table(), 'status');
    }
}
