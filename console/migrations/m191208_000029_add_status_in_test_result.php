<?php

use \yii\db\Migration;

class m191208_000029_add_status_in_test_result extends Migration
{
    private function table() {
        return \testing\models\TestResult::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'status', $this->integer(1)->defaultValue(0));
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'status');
    }
}
