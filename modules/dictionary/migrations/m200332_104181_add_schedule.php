<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictCseSubject;
use modules\entrant\models\AnketaCi;
use yii\db\Migration;


class m200332_104181_add_schedule extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'dict_schedule';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'date' => $this->date()->notNull(),
            'count' => $this->integer(4)->notNull(),
            'category' => $this->integer(3)->notNull(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
