<?php

namespace modules\entrant\migrations;

use modules\entrant\models\Agreement;
use yii\db\Migration;

class m191208_000148_add_competitive_groups_column_for_agreement extends Migration
{
    private function table()
    {
        return Agreement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "competitive_list", $this->json());
    }
}