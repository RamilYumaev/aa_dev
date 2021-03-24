<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;

/**
 * Class m200331_104158_table_dict_organization
 */
class m200332_104159_add_only_spo_dict_competitive extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return DictCompetitiveGroup::tableName();
    }

    public function up()
    {

        $this->addColumn($this->table(), "only_spo", $this
            ->integer()
            ->defaultValue(0)
            ->comment("только для выпускников колледжей"));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn($this->table(), "dvi");
    }
}
