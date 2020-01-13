<?php

use \yii\db\Migration;

class m190124_110265_add_columns_status_test_attempt extends Migration
{
    private function table() {
        return \testing\models\TestAttempt::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'status', $this->integer()->defaultValue(0));
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'status');
    }
}
