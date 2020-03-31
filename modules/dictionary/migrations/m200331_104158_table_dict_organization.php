<?php

namespace modules\dictionary\migrations;

use yii\db\Migration;
use \modules\dictionary\models\DictOrganizations;

/**
 * Class m200331_104158_table_dict_organization
 */
class m200331_104158_table_dict_organization extends Migration
{

    private function table()
    {
        return DictOrganizations::tableName();
    }

    /**
     * {@inheritdoc}
     */

    public function up()
    {

        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            "id" => $this->primaryKey(),
            "name" => $this->text()->notNull()->comment("Наименование организации")
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable($this->table());
    }
}
