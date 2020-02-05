<?php

use \yii\db\Migration;

class m190124_110277_add_columns_in_table_dict_school extends Migration
{
    private function table() {
        return \dictionary\models\DictSchools::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'moderated_by', $this->integer());
        $this->alterColumn($this->table(), 'status', $this->smallInteger());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'moderated_by');
        $this->alterColumn($this->table(), 'status', $this->integer()->defaultValue(0));
    }
}
