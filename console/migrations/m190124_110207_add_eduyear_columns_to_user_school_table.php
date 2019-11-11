<?php

use \yii\db\Migration;

class m190124_110207_add_eduyear_columns_to_user_school_table extends Migration
{
    private function table() {
        return \common\auth\models\UserSchool::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(), 'edu_year', $this->string()->notNull()->defaultValue("2018/2019"));
    }

    public function down()
    {
      $this->dropColumn($this->table(), 'edu_year');
    }
}
