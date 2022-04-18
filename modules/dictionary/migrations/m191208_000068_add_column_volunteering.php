<?php
namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000068_add_column_volunteering extends Migration
{
    private function table() {
        return 'volunteering';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'conditions_of_work', $this->smallInteger()->defaultValue(0));
    }
}
