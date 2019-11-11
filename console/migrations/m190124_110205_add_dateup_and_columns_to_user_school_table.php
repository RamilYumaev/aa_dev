<?php

use \yii\db\Migration;

class m190124_110205_add_dateup_and_columns_to_user_school_table extends Migration
{
    private function table() {
        return \common\auth\models\UserSchool::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'created_at', $this->integer()->notNull()->defaultValue(1559260800));
      $this->addColumn($this->table(), 'updated_at', $this->integer()->notNull()->defaultValue(1559260800));
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'created_at');
      $this->dropColumn($this->table(), 'updated_at');
    }
}
