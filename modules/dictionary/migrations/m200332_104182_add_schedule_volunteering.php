<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\AnketaCi;
use yii\db\Migration;


class m200332_104182_add_schedule_volunteering extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'schedule_volunteering';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'dict_schedule_id' => $this->integer(),
            'job_entrant_id' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-schedule_volunteering-dict_schedule_id}}', $this->table(), 'dict_schedule_id', 'dict_schedule', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-idx-schedule_volunteering-dict-job_entrant}}', $this->table(), 'job_entrant_id', JobEntrant::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
