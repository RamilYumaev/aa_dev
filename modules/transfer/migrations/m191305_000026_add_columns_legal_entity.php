<?php

namespace modules\transfer\migrations;
use common\auth\models\User;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191305_000026_add_columns_legal_entity extends Migration
{
    private function table() {
        return 'legal_entity_transfer';
    }

    public function up()
    {
        $this->addColumn($this->table(),'fio', $this->string()->notNull());
        $this->addColumn($this->table(),'position', $this->string()->notNull());
        $this->addColumn($this->table(),'footing', $this->string()->notNull());
        $this->addColumn($this->table(),'requisites', $this->string()->null());
    }

    public function down()
    {
    }
}
