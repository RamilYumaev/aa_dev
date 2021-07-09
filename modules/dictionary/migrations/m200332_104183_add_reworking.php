<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\AnketaCi;
use yii\db\Migration;


class m200332_104183_add_reworking extends Migration
{
    /**
     * {@inheritdoc}
     */
    private function table()
    {
        return 'reworking_volunteering';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'schedule_volunteering_id' => $this->integer(),
            'text' => $this->text(),
            'count_hours' => $this->integer(3),
            'status' => $this->integer(1)->defaultValue(0),
            'recall_text' => $this->text(),
            'job_entrant_admin_id' => $this->integer()->null()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-reworking_volunteering-schedule_volunteering_id}}', $this->table(), 'schedule_volunteering_id', 'schedule_volunteering', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-idx-schedule_volunteering_id-job_entrant_admin_id}}', $this->table(), 'job_entrant_admin_id', JobEntrant::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
