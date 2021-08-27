<?php
namespace modules\entrant\migrations;

use dictionary\models\DictCompetitiveGroup;
use \yii\db\Migration;

class  m191208_000133_drop_and_add_column_event extends Migration
{
    private function table() {
        return 'event';
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'cg_id');
        $this->addColumn($this->table(), 'is_published', $this->boolean()->defaultValue(0));
    }


}
