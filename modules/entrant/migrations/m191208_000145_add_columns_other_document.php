<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Address;
use modules\entrant\models\OtherDocument;
use \yii\db\Migration;

class m191208_000145_add_columns_other_document extends Migration
{
    private function table() {
        return OtherDocument::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'country_id', $this->integer()->null());
    }
}
