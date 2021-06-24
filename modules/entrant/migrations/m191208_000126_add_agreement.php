<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000126_add_agreement extends Migration
{
    private function table() {
        return \modules\entrant\models\Agreement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'ais_id' , $this->integer()->null());
     }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
