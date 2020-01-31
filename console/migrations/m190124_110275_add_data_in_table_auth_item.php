<?php

use \yii\db\Migration;

class m190124_110275_add_data_in_table_auth_item extends Migration
{
    private function table() {
        return \olympic\models\auth\AuthItem::tableName();
    }

    public function up()
    {
      $this->insert($this->table(), [
          'name' => 'olympic_teacher',
          'type' => 2,
          'description' => "Учитель, преподаватель",
          'created_at' => time(),
          'updated_at' => time(),
      ]);
    }

    public function down()
    {
      $this->delete($this->table(),'name = olympic_teacher');
    }
}
