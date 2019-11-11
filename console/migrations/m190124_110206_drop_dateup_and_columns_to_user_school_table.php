<?php

use \yii\db\Migration;

class m190124_110206_drop_dateup_and_columns_to_user_school_table extends Migration
{
    private function table() {
        return \common\auth\models\UserSchool::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'created_at');
        $this->dropColumn($this->table(), 'updated_at');
    }

    public function down()
    {
        $this->addColumn($this->table(), 'created_at', $this->integer()->notNull()->defaultValue(1559260800));
        $this->addColumn($this->table(), 'updated_at', $this->integer()->notNull()->defaultValue(1559260800));
    }
}
