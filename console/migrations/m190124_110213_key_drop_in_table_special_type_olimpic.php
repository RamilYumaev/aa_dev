<?php

use \yii\db\Migration;

class m190124_110213_key_drop_in_table_special_type_olimpic extends Migration
{
    private function table() {
        return \olympic\models\SpecialTypeOlimpic::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("special_type_olimpic_ibfk_1", $this->table());
}

    public function down()
    {
        echo '';
    }
}
