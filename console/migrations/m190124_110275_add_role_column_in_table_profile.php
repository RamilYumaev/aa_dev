<?php

use \yii\db\Migration;

class m190124_110275_add_role_column_in_table_profile extends Migration
{
    private function table() {
        return \olympic\models\auth\Profiles::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'role', $this->integer()->defaultValue(0));
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'role');
    }
}
