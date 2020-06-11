<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000064_add_columns_statement_rejection_consent extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementRejectionCgConsent::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(),'status_id', $this->integer()->defaultValue(0));
    }

    public function down()
    {

    }
}
