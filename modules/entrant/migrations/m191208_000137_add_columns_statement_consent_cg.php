<?php
namespace modules\entrant\migrations;
use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191208_000137_add_columns_statement_consent_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementConsentCg::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'check_original', $this->boolean()->defaultValue(0));

    }

    public function down()
    {
        $this->dropColumn($this->table(), 'check_original');
    }
}
