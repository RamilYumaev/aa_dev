<?php

namespace modules\dictionary\migrations;

use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictCseSubject;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\AnketaCi;
use yii\db\Migration;


class  m200332_104184_add_admin_center extends Migration
{

    /**
     * {@inheritdoc}
     */

    private function table()
    {
        return 'admin_center';
    }

    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'job_entrant_id' => $this->integer(),
            'category' => $this->integer(4)->notNull()
        ], $tableOptions);

        $this->addForeignKey('{{%fk-idx-admin_center-job_entrant_id}}', $this->table(), 'job_entrant_id', JobEntrant::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
