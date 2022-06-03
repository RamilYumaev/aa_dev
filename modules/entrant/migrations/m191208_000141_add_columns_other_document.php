<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000141_add_columns_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    /**
     * @return false|mixed|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->addColumn($this->table(), 'reception_quota', $this->integer()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'reception_quota');
    }
}
