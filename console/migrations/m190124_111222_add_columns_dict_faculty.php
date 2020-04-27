<?php

use \yii\db\Migration;

class m190124_111222_add_columns_dict_faculty extends Migration
{
    private function table() {
        return \dictionary\models\Faculty::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'short', $this->string()->null());
      $this->addColumn($this->table(), 'genitive_name', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'short');
        $this->dropColumn($this->table(), 'genitive_name');
    }
}
