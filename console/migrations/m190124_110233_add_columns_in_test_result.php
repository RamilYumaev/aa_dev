<?php

use \yii\db\Migration;
use  \dictionary\models\DictChairmans;

class m190124_110233_add_columns_in_test_result extends Migration
{
    protected function table() {
        return \testing\models\TestResult::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'priority', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn($this->table(), 'tq_id', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'priority');
        $this->dropColumn($this->table(), 'tq_id');
    }
}
