<?php

use \yii\db\Migration;

class  m191208_000008_add_role_entrant extends Migration
{
    private function table() {
        return \olympic\models\auth\AuthItem::tableName();
    }

    public function up()
    {
        $this->insert($this->table(), ['name'=> \common\auth\rbac\Rbac::ROLE_ENTRANT, 'type' => 1]);

    }

    public function down()
    {
        echo "";
    }
}
