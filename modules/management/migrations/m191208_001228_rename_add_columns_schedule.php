<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001228_rename_add_columns_schedule extends Migration
{
    private function table() {
        return Schedule::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'monday_odd', $this->string(11)->notNull()->defaultValue('')->after('monday'));
        $this->renameColumn($this->table(),'monday', 'monday_even');
        $this->addColumn($this->table(), 'tuesday_odd', $this->string(11)->notNull()->defaultValue('')->after('tuesday'));
        $this->renameColumn($this->table(),'tuesday', 'tuesday_even');
        $this->addColumn($this->table(), 'wednesday_odd', $this->string(11)->notNull()->defaultValue('')->after('wednesday'));
        $this->renameColumn($this->table(),'wednesday', 'wednesday_even');
        $this->addColumn($this->table(), 'thursday_odd', $this->string(11)->notNull()->defaultValue('')->after('thursday'));
        $this->renameColumn($this->table(),'thursday', 'thursday_even');
        $this->addColumn($this->table(), 'friday_odd', $this->string(11)->notNull()->defaultValue('')->after('friday'));
        $this->renameColumn($this->table(),'friday', 'friday_even');
        $this->addColumn($this->table(), 'saturday_odd', $this->string(11)->notNull()->defaultValue('')->after('saturday'));
        $this->renameColumn($this->table(),'saturday', 'saturday_even');
        $this->addColumn($this->table(), 'sunday_odd', $this->string(11)->notNull()->defaultValue('')->after('sunday'));
        $this->renameColumn($this->table(),'sunday', 'sunday_even');
    }

    public function down()
    {
    }
}
