<?php

use \yii\db\Migration;

class m190124_110208_alter_column_to_year_olympic_list_table extends Migration
{
    private function table() {
        return \olympic\models\OlimpicList::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), "year",  $this->string()->notNull()->defaultValue("2018/2019"));
    }

    public function down()
    {
      echo  "";
    }
}
