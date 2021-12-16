<?php
namespace modules\transfer\migrations;

use modules\transfer\models\StatementTransfer;
use \yii\db\Migration;

class m191305_000041_pas_exam extends Migration
{
    private function table() {
        return 'pass_exam';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'success_exam', $this->integer(1)->defaultValue(0));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
