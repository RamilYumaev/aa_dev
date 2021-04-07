<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000052_rename_column_setting_competition_list extends Migration
{
    private function table() {
        return 'setting_competition_list';
    }

    public function up()
    {
        $this->renameColumn($this->table(), 'time_start_end', 'time_end_week');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
