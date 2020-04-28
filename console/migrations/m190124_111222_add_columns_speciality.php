<?php

use \yii\db\Migration;

class m190124_111222_add_columns_speciality extends Migration
{
    private function table() {
        return \dictionary\models\DictSpeciality::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'short', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'short');
    }
}
