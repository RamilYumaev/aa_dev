<?php

use \yii\db\Migration;

class m190124_110210_add_id_columns_to_user_school_table extends Migration
{
    private function table() {
        return \common\auth\models\UserSchool::tableName();
    }

    public function up()
    {
        $this->dropPrimaryKey('user_id', $this->table());
        $this->addColumn($this->table(), 'id', $this->primaryKey()->first());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'id');
        $this->addPrimaryKey('user_id', $this->table(), 'user_key');
    }
}
