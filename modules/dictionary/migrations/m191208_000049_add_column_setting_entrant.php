<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictClass;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000049_add_column_setting_entrant extends Migration
{
    private function table() {
        return 'setting_entrant';
    }

    public function up()
    {
        $this->addColumn($this->table(), "foreign_status", $this->boolean());
        $this->addColumn($this->table(), "tpgu_status", $this->boolean());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
