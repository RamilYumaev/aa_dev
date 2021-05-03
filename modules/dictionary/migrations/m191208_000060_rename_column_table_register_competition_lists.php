<?php
namespace modules\dictionary\migrations;
use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000060_rename_column_table_register_competition_lists extends Migration
{
    private function table() {
        return 'register_competition_list';
    }

    public function up()
    {
        $this->renameColumn($this->table(),'specialization_id','speciality_id');
    }
}
