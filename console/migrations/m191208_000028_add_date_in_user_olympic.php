<?php

use \yii\db\Migration;

class m191208_000028_add_date_in_user_olympic extends Migration
{
    private function table() {
        return \olympic\models\UserOlimpiads::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'created_at', $this->integer()->null());
      $this->addColumn($this->table(), 'updated_at', $this->integer()->null());
      $this->addColumn($this->table(), 'information', $this->json()->null());
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'created_at');
      $this->dropColumn($this->table(), 'updated_at');
    }
}
