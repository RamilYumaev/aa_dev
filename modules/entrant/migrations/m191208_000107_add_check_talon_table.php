<?php

namespace modules\entrant\migrations;

use api\providers\User;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\AnketaCi;
use modules\entrant\models\Talons;

class m191208_000107_add_check_talon_table extends \yii\db\Migration
{
    private function table()
    {
        return Talons::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'user_id', $this->integer()->null());

        $this->addForeignKey('{{%fk-talons-user_id}}', $this->table(), 'user_id', User::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }

}