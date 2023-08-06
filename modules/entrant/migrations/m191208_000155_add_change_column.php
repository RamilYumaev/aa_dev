<?php

namespace modules\entrant\migrations;
use modules\entrant\models\LegalEntity;
use \yii\db\Migration;

class m191208_000155_add_change_column extends Migration
{
    private function table() {
        return "competitive_list_ones";
    }

    public function up()
    {
        $this->renameColumn($this->table(), 'is_recommend_transfer', 'number');
        $this->alterColumn($this->table(), 'number', $this->integer(0)->defaultValue(0));
    }
}
