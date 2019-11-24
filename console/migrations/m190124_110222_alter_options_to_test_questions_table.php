<?php

use \yii\db\Migration;

class m190124_110222_alter_options_to_test_questions_table extends Migration
{
    private function table() {
        return \testing\models\TestQuestion::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'options', $this->text()->null());
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'options', $this->text()->notNull());
    }
}
