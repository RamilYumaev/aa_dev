<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104165_add_and_delete_colum_table_testing_entrant extends Migration
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
        $this->addColumn($this->table(), 'title', $this->string());
        $this->dropColumn($this->table(), 'role');
    }
}
