<?php

use \yii\db\Migration;

class m191208_000007_add_column_in_dod_date extends Migration
{
    private function table() {
        return \dod\models\DateDod::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'type', $this->integer(1)->defaultValue(1)->notNull()
            ->comment('1-очный тип; 2-очный тип с прямой трансляцией; 
            3-вебинар; 4-дистанционный тип; 5-гибридный тип (очный и дистанционный); 
            6-дистанционный для учебных организаций.'));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'type');
    }
}
