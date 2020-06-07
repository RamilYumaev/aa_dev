<?php

namespace modules\entrant\migrations;
use common\auth\models\User;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000058_add_columns_legal_entity extends Migration
{
    private function table() {
        return 'legal_entity';
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
