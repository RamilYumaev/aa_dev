<?php

use \yii\db\Migration;

class m190124_110238_key_drop_in_table_presence_att extends Migration
{
    private function table() {
        return \olympic\models\PersonalPresenceAttempt::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("personal_presence_attempt_ibfk_1", $this->table());
    }

    public function down()
    {
        echo '';
    }
}
