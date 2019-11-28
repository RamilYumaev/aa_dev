<?php

use \yii\db\Migration;

class m190124_110227_add_mark_in_table_taq extends Migration
{
    private function table() {
        return \testing\models\TestAndQuestions::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'mark', $this->integer()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'mark');
    }
}
