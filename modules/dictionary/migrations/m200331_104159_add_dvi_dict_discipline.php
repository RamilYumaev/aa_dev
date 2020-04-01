<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use yii\db\Migration;
use \modules\dictionary\models\DictOrganizations;

/**
 * Class m200331_104158_table_dict_organization
 */
class m200331_104159_add_dvi_dict_discipline extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return DictDiscipline::tableName();
    }

    public function up()
    {

        $this->addColumn($this->table(), "dvi", $this
            ->integer()
            ->defaultValue(null)
            ->comment("Дополнительное вступительное испытание"));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn($this->table(), "dvi");
    }
}
