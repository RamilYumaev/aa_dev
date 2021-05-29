<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104164_altrer_colum_table_testing_entrant extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'testing_entrant';
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'category', $this->integer()->null());
        $this->alterColumn($this->table(), 'country', $this->integer()->null());
        $this->alterColumn($this->table(), 'edu_document', $this->integer());
    }
}
