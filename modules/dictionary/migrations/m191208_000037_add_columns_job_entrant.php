<?php
namespace modules\dictionary\migrations;

use common\auth\models\SettingEmail;
use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000037_add_columns_job_entrant extends Migration
{
    private function table() {
        return JobEntrant::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'email_id', $this->integer()->null());

        $this->createIndex('{{%idx-job_entrant-email_id}}', $this->table(), 'email_id');
        $this->addForeignKey('{{%fk-job_entrant-email_id}}', $this->table(), 'email_id', SettingEmail::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
    }
}
