<?php

use \yii\db\Migration;

class m190124_110209_drop_and_add_column_to_year_olympic_list_table extends Migration
{
    private function table() {
        return \olympic\models\OlimpicList::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), "year");
        $this->addColumn($this->table(), 'year', $this->string()->notNull()->defaultValue("2018/2019"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'year');
        $this->addColumn($this->table(), 'year',
            $this->integer(4)->defaultValue(2019)->after('current_status'));
    }
}
