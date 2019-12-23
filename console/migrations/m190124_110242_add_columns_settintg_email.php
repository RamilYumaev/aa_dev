<?php
use \yii\db\Migration;

class m190124_110242_add_columns_settintg_email extends Migration
{
    private function table() {
        return \common\auth\models\SettingEmail::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'status', $this->integer(1)->notNull()->defaultValue(0)->comment("0 - не проверена , 1 - проверена"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'status');
    }
}
