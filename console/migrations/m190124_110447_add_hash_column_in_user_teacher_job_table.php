<?php

use \yii\db\Migration;

class m190124_110447_add_hash_column_in_user_teacher_job_table extends Migration
{
    private function table() {
        return \teacher\models\UserTeacherJob::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'hash', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'hash');
    }
}
