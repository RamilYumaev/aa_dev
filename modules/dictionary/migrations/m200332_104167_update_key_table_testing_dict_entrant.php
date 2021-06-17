<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use yii\db\Migration;


class m200332_104167_update_key_table_testing_dict_entrant extends Migration
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
        $this->dropForeignKey('{{%fk-idx-testing_entrant_dict-id_testing_entrant}}', $this->table());
        $this->dropIndex('{{%idx-testing_entrant_dict-id_testing_entrant}}', $this->table());

        $this->createIndex('{{%idx-testing_entrant_dict-id_testing_entrant}}', $this->table(), 'id_testing_entrant');
        $this->addForeignKey('{{%fk-idx-testing_entrant_dict-id_testing_entrant}}', $this->table(), 'id_testing_entrant', 'testing_entrant', 'id',  'CASCADE', 'RESTRICT');

        $this->dropForeignKey('{{%fk-idx-testing_entrant_dict-id_dict_testing_entrant}}', $this->table());
        $this->dropIndex('{{%idx-testing_entrant_dict-id_dict_testing_entrant}}', $this->table());

        $this->createIndex('{{%idx-testing_entrant_dict-id_dict_testing_entrant}}', $this->table(), 'id_dict_testing_entrant');
        $this->addForeignKey('{{%fk-idx-testing_entrant_dict-id_dict_testing_entrant}}', $this->table(), 'id_dict_testing_entrant', 'dict_testing_entrant', 'id',   'CASCADE', 'RESTRICT');
    }


}
