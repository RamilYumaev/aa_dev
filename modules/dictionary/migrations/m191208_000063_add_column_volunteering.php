<?php
namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000063_add_column_volunteering extends Migration
{
    private function table() {
        return 'volunteering';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_reception', $this->boolean());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
