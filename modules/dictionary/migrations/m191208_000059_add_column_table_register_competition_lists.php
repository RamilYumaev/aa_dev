<?php
namespace modules\dictionary\migrations;
use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000059_add_column_table_register_competition_lists extends Migration
{
    private function table() {
        return 'register_competition_list';
    }

    public function up()
    {
        $this->alterColumn($this->table(),'ais_cg_id', $this->text());
        $this->addColumn($this->table(),'specialization_id',$this->integer()->defaultValue(0));
        $this->addColumn($this->table(),'faculty_id',$this->integer()->defaultValue(0));
    }
}
