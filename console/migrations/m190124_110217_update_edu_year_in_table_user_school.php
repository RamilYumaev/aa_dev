<?php

use \yii\db\Migration;

class m190124_110217_update_edu_year_in_table_user_school extends Migration
{
    private function table() {
        return \common\auth\models\UserSchool::tableName();
    }

    public function up()
    {
        $this->update($this->table(),['edu_year' => '2018-2019'], ['edu_year' => '2018/2019']);
    }

    public function down()
    {
        $this->update($this->table(), ['edu_year' => '2018/2019'], ['edu_year' => '2018-2019']);
    }
}
