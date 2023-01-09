<?php
namespace modules\transfer\migrations;
use dictionary\models\DictCompetitiveGroup;
use \yii\db\Migration;

class m191305_000048_add_columns_cg extends Migration
{
    private function table() {
        return DictCompetitiveGroup::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_unavailable_transfer', $this->boolean()->defaultValue(0));
    }
}
