<?php

use \yii\db\Migration;

class m191208_000001_add_column_in_table_profile extends Migration
{
    private function table() {
        return \olympic\models\auth\Profiles::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'gender', $this->integer(1)->null()->comment("1-мужской, 2-женский"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'gender');
    }
}
