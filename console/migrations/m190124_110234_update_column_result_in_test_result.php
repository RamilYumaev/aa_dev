<?php

use \yii\db\Migration;
use  \dictionary\models\DictChairmans;

class m190124_110234_update_column_result_in_test_result extends Migration
{
    protected function table() {
        return \testing\models\TestResult::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'result', $this->text()->null());
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'result', $this->text()->notNull());
    }
}
