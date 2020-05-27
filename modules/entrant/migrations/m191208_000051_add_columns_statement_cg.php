<?php
namespace modules\entrant\migrations;
use modules\dictionary\models\DictCathedra;
use \yii\db\Migration;

class m191208_000051_add_columns_statement_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementCg::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "cathedra_id", $this->smallInteger(5)->null());
        $this->createIndex('{{%idx-statemnet_cg-cathedra_id}}', $this->table(),'cathedra_id');
        $this->addForeignKey('{{%fk-idx-statement_cg-cathedra_id}}', $this->table(), 'cathedra_id', DictCathedra::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {

    }
}
