<?php

namespace modules\dictionary\migrations;

use dictionary\models\Region;
use modules\dictionary\models\DictIndividualAchievement;
use yii\db\Migration;


class m200332_104186_add_column_ia extends Migration
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
        $this->alterColumn($this->table(), 'name', $this->text()->notNull());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
