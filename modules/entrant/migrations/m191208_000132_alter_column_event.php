<?php
namespace modules\entrant\migrations;

use dictionary\models\DictCompetitiveGroup;
use \yii\db\Migration;

class m191208_000132_alter_column_event extends Migration
{
    private function table() {
        return 'event';
    }

    public function up()
    {
        $this->dropForeignKey("fk-cg-key", $this->table());
        $this->dropIndex("fk-cg-key", $this->table());
        $this->truncateTable($this->table());
        $this->alterColumn($this->table(), 'cg_id', $this->json());
    }


}
