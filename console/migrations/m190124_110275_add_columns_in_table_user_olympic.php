<?php

use \yii\db\Migration;

class m190124_110275_add_columns_in_table_user_olympic extends Migration
{
    private function table() {
        return \olympic\models\UserOlimpiads::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'teacher_id', $this->integer()->null());
        $this->addColumn($this->table(), 'status', $this->integer()->defaultValue(0));
        $this->addColumn($this->table(), 'hash', $this->string()->null());

        $this->createIndex('{{%idx-teacher_id}}', $this->table(), 'teacher_id');
        $this->addForeignKey('{{%fk-idx-teacher_id}}', $this->table(), 'teacher_id',
            \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'teacher_id');
        $this->dropColumn($this->table(), 'status');
        $this->dropColumn($this->table(), 'hash');
    }
}
