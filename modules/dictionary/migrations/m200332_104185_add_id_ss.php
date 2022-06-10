<?php

namespace modules\dictionary\migrations;

use dictionary\models\Region;
use yii\db\Migration;


class m200332_104185_add_id_ss extends Migration
{
    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return Region::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'ss_id', $this->integer()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
