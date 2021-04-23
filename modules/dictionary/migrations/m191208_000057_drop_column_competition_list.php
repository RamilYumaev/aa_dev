<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\RegisterCompetitionList;
use \yii\db\Migration;

class m191208_000057_drop_column_competition_list extends Migration
{
    private function table() {
        return 'competition_list';
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'status');
        $this->truncateTable($this->table());
        $this->addColumn($this->table(), 'rcl_id', $this->integer()->notNull());

        $this->createIndex('{{%idx-competition_list-rcl_id}}', $this->table(), 'rcl_id');
        $this->addForeignKey('{{%fk-idx-competition_list-rcl_id}}', $this->table(), 'rcl_id', RegisterCompetitionList::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

}
