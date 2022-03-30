<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use \yii\db\Migration;

class m191208_000135_add_columns_anketa extends Migration
{
    private function table() {
        return Anketa::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'is_agree', $this->boolean()->defaultValue(0));
        $this->dropColumn($this->table(), 'edu_finish_year');
    }

    public function down()
    {
        $this->dropColumn($this->table(),'is_agree');
    }

}
