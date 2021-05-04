<?php
namespace modules\dictionary\migrations;
use modules\dictionary\models\SettingCompetitionList;
use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000061_add_column_table_setting_competition_lists extends Migration
{
    private function table() {
        return SettingCompetitionList::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'end_date_zuk', $this->dateTime()->null());
    }
}
