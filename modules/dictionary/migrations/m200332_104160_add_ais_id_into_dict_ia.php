<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictIndividualAchievement;
use yii\db\Migration;

/**
 * Class m200331_104158_table_dict_organization
 */
class m200332_104160_add_ais_id_into_dict_ia extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return DictIndividualAchievement::tableName();
    }

    public function up()
    {

        $this->addColumn($this->table(), "ais_id", $this
            ->integer()
            ->defaultValue(0)
            ->comment("id из справочника АИС ВУЗ"));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn($this->table(), "ais_id");
    }
}
