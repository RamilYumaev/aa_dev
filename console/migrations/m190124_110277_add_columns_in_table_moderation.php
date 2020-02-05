<?php

use \yii\db\Migration;

class m190124_110277_add_columns_in_table_moderation extends Migration
{
    private function table() {
        return \common\moderation\models\Moderation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'moderated_by', $this->integer());
        $this->addColumn($this->table(), 'status', $this->smallInteger()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'moderated_by');
        $this->dropColumn($this->table(), 'status');
    }
}
