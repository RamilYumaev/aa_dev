<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104162_add_table_testing_dict_entrant extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'testing_entrant_dict';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id_dict_testing_entrant' => $this->integer(),
            'id_testing_entrant' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),
            'error_note' => $this->text(),
            'status_programmer' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->addPrimaryKey('testing_entrant_dict-primary', $this->table(), ['id_dict_testing_entrant', 'id_testing_entrant']);

        $this->createIndex('{{%idx-testing_entrant_dict-id_testing_entrant}}', $this->table(), 'id_testing_entrant');
        $this->addForeignKey('{{%fk-idx-testing_entrant_dict-id_testing_entrant}}', $this->table(), 'id_testing_entrant', 'testing_entrant', 'id',  'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%idx-testing_entrant_dict-id_dict_testing_entrant}}', $this->table(), 'id_dict_testing_entrant');
        $this->addForeignKey('{{%fk-idx-testing_entrant_dict-id_dict_testing_entrant}}', $this->table(), 'id_dict_testing_entrant', 'dict_testing_entrant', 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }

}
