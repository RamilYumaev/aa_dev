<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104166_add_column_dict_testing_entrant extends Migration
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
        $this->addColumn($this->table(), 'count_files', $this->integer(2)->defaultValue(0));
    }
}
