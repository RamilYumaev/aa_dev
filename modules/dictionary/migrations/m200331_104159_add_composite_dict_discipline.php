<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use yii\db\Migration;
use \modules\dictionary\models\DictOrganizations;

/**
 * Class m200331_104158_table_dict_organization
 */
class m200331_104159_add_composite_dict_discipline extends Migration
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

        $this->addColumn($this->table(), "composite_discipline", $this
            ->integer()
            ->defaultValue(null)
            ->comment("Составная дисциплина"));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn($this->table(), "composite_discipline");
    }
}
