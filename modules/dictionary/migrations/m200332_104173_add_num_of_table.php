<?php

namespace modules\dictionary\migrations;


use modules\entrant\models\Talons;
use yii\db\Migration;

class m200332_104173_add_num_of_table extends Migration
{
    private function table()
    {
        return Talons::tableName();
    }

    public function up(){
        $this->addColumn($this->table(), 'num_of_table', $this->integer(2)->null());
    }

    public function down(){
        $this->dropColumn($this->table(), 'num_of_table');
    }

}