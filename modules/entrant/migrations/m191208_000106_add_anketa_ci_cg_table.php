<?php

namespace modules\entrant\migrations;

use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\AnketaCi;

class m191208_000106_add_anketa_ci_cg_table extends \yii\db\Migration
{
    private function table()
    {
        return "anketa_ci_cg";
    }

    public function up()
    {
        $tableOption = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=innoDB";
        $this->createTable($this->table(), [
            'id_anketa' => $this->integer()->notNull(),
            'competitive_group_id' => $this->integer()->notNull(),

        ], $tableOption);

        $this->createIndex('{{%idx-anketa_ci_cg-id_anketa}}',
            $this->table(), ['id_anketa', 'competitive_group_id'], true);
        $this->addForeignKey('{{%fk-anketa_ci_cg-id-anketa}}', $this->table(), 'id_anketa', AnketaCi::tableName(), 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-anketa_ci_cg-competitive-group-id}}', $this->table(), 'competitive_group_id', DictCompetitiveGroup::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }

}