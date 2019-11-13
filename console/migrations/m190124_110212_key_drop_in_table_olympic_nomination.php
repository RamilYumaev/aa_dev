<?php

use \yii\db\Migration;

class m190124_110212_key_drop_in_table_olympic_nomination extends Migration
{
    private function table() {
        return \olympic\models\OlimpicNomination::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("olimpic_nomination_ibfk_1", $this->table());
    }

    public function down()
    {
        echo '';
    }
}
