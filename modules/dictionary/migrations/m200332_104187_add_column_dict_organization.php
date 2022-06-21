<?php

namespace modules\dictionary\migrations;

use modules\dictionary\models\DictOrganizations;
use yii\db\Migration;


class m200332_104187_add_column_dict_organization extends Migration
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
        $this->addColumn($this->table(), 'short_name', $this->string()->notNull()->defaultValue(''));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
