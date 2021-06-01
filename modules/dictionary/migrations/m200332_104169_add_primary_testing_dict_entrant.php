<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104169_add_primary_testing_dict_entrant extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'testing_entrant_dict';
    }

    public function up()
    {
        $this->addPrimaryKey('testing_entrant_dict-primary', $this->table(), ['id_dict_testing_entrant', 'id_testing_entrant']);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
