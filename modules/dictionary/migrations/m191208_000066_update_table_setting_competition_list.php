<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000066_update_table_setting_competition_list extends Migration
{
    private function table() {
        return 'setting_competition_list';
    }

    public function up()
    {

        $this->dropForeignKey('{{%fk-idx-setting_competition_list-se_id}}', $this->table());
        $this->addForeignKey('{{%fk-idx-setting_competition_list-se_id}}', $this->table(), 'se_id', SettingEntrant::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
