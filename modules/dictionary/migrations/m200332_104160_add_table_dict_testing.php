<?php

namespace modules\dictionary\migrations;

use yii\db\Migration;


class m200332_104160_add_table_dict_testing extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'dict_testing_entrant';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('Наименование'),
            'description' => $this->text(),
            'is_auto' => $this->boolean()->defaultValue(false),
            'result' => $this->text(),
            'priority' => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }

}
