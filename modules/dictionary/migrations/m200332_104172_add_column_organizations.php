<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\models\DictOrganizations;
use yii\db\Migration;


class m200332_104172_add_column_organizations extends Migration
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
        $this->addColumn($this->table(), 'ogrn', $this->string(13)->null());
        $this->addColumn($this->table(), 'kpp', $this->string(9)->null());
        $this->addColumn($this->table(), 'region_id', $this->integer()->defaultValue(49)->null());

        $this->createIndex('{{%idx-region_id}}', $this->table(), 'region_id');
        $this->addForeignKey('{{%fk-idx-region}}', $this->table(), 'region_id', \dictionary\models\Region::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
