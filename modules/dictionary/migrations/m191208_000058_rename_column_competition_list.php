<?php
namespace modules\dictionary\migrations;
use \yii\db\Migration;

class m191208_000058_rename_column_competition_list extends Migration
{
    private function table() {
        return 'competition_list';
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'ais_cg_id');
        $this->alterColumn($this->table(), 'type', $this->string(10)->defaultValue(''));
    }
}
