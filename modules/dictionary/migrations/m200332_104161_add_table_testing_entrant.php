<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104161_add_table_testing_entrant extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'testing_entrant';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'department' => $this->json(),
            'special_right' => $this->json(),
            'edu_level' => $this->json(),
            'edu_document' => $this->json(),
            'country' => $this->json(),
            'category' => $this->json(),
            'role' => $this->integer(),
            'fio' => $this->string()->null(),
            'user_id'=> $this->integer()->null(),
            'note' => $this->text(),
            'status' => $this->integer()->defaultValue(0)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }

}
