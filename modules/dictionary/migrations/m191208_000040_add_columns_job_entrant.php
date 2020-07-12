<?php
namespace modules\dictionary\migrations;

use common\auth\models\SettingEmail;
use dictionary\models\Faculty;
use modules\dictionary\models\DictExaminer;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000040_add_columns_job_entrant extends Migration
{
    private function table() {
        return JobEntrant::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'examiner_id', $this->integer()->null());

        $this->createIndex('{{%idx-job_entrant-examiner_id}}', $this->table(), 'examiner_id');
        $this->addForeignKey('{{%fk-job_entrant-examiner_id}}', $this->table(), 'examiner_id', DictExaminer::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
    }
}
