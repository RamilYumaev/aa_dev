<?php
namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use \yii\db\Migration;

class m191208_000083_add_columns_dict_competitive extends Migration
{
    private function table() {
        return DictCompetitiveGroup::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "tpgu_status", $this->integer()->defaultValue(0));
        $this->addColumn($this->table(), "additional_set_status", $this->integer()->defaultValue(0));
    }

}
