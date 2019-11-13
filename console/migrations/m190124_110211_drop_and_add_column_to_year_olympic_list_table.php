<?php

use \yii\db\Migration;

class m190124_110211_drop_and_add_column_to_year_olympic_list_table extends Migration
{
    private function table() {
        return \olympic\models\OlimpicList::tableName();
    }

    public function up()
    {
        $rows = (new \yii\db\Query())->select(['year'])->from($this->table())->all();

        foreach ($rows as $row) {
            $this->update($this->table(), ['year' => "2018-2019"]);
        }
    }

    public function down()
    {
        echo '';
    }
}
