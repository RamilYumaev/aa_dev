<?php

use \yii\db\Migration;

class m190124_110215_add_id_columns_to_user_olympiads extends Migration
{
    private function table() {
        return \olympic\models\UserOlimpiads::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'id', $this->primaryKey()->first());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'id');
    }
}
