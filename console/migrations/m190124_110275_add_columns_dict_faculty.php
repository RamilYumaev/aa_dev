<?php

use \yii\db\Migration;

class m190124_110275_add_columns_dict_faculty extends Migration
{
    private function table() {
        return \dictionary\models\Faculty::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'filial', $this->integer()->defaultValue(0));
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'filial');
    }
}
