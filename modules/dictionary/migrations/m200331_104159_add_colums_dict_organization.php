<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use yii\db\Migration;
use \modules\dictionary\models\DictOrganizations;

/**
 * Class m200331_104158_table_dict_organization
 */
class m200331_104159_add_colums_dict_organization extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return DictOrganizations::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "ais_id", $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn($this->table(), "ais_id");
    }
}
