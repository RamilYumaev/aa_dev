<?php

use \yii\db\Migration;

class  m191208_000015_add_columns_user_token_ais extends Migration
{
    private function table() {
        return \common\auth\models\User::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'ais_token', $this->string()->unique());

    }

    public function down()
    {
        echo "";
    }
}
