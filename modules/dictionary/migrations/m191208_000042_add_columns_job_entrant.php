<?php
namespace modules\dictionary\migrations;

use common\auth\models\SettingEmail;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000042_add_columns_job_entrant extends Migration
{
    private function table() {
        return JobEntrant::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'post', $this->integer()->null());
    }

    public function down()
    {
    }
}
