<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000056_add_column_setting_competition_list extends Migration
{
    private function table() {
        return 'setting_competition_list';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_auto', $this->boolean()->defaultValue(true));
    }

}
