<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictCseSubject;
use modules\entrant\models\AnketaCi;
use yii\db\Migration;


class m200332_104170_add_talons extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'talons';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'anketa_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'date' => $this->string(10)->notNull(),
            'status'=> $this->integer(2)->notNull(),
        ], $tableOptions);

        $this->createIndex("name_date", $this->table(), ['name', 'date'], true);
        $this->addForeignKey('{{%fk-talons-anketa_ci}}', $this->table(), 'anketa_id', AnketaCi::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
