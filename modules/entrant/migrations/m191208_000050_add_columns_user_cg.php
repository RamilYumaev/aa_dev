<?php
namespace modules\entrant\migrations;
use modules\dictionary\models\DictCathedra;
use \yii\db\Migration;

class m191208_000050_add_columns_user_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\UserCg::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "cathedra_id", $this->smallInteger(5)->null());
        $this->createIndex('{{%idx-user_cg-cathedra_id}}', $this->table(),'cathedra_id');
        $this->addForeignKey('{{%fk-idx-user_cg-cathedra_id}}', $this->table(), 'cathedra_id', DictCathedra::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {

    }
}
