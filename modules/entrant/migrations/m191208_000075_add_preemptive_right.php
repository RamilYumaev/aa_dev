<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use modules\entrant\models\OtherDocument;
use \yii\db\Migration;

class m191208_000075_add_preemptive_right extends Migration
{
    private function table() {
        return \modules\entrant\models\PreemptiveRight::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'message', $this->string()->null());

    }

}
