<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use modules\entrant\models\AnketaCi;
use yii\db\Migration;


class m200332_104170_add_cse_result_ci extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'cse_results_ci';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'anketa_id' => $this->integer()->notNull(),
            'year' => $this->integer()->notNull(),
            'cse_id' => $this->integer()->notNull(),
            'ball' => $this->integer()->notNull()], $tableOptions);

        $this->addForeignKey('{{%fk-anketa_ci}}', $this->table(), 'anketa_id', AnketaCi::tableName(), 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-dict-discipline}}', $this->table(), 'cse_id', DictDiscipline::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
