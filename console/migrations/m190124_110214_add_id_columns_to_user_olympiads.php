<?php

use \yii\db\Migration;

class m190124_110214_add_id_columns_to_user_olympiads extends Migration
{
    private function table() {
        return \olympic\models\UserOlimpiads::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("user_olimpiads_ibfk_1", $this->table());
        $this->dropForeignKey("user_olimpiads_ibfk_2", $this->table());
        $this->dropPrimaryKey('olympiads_id', $this->table());
    }

    public function down()
    {
     echo "";
    }
}
