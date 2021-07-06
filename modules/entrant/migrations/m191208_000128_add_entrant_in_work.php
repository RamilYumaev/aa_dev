<?php

namespace modules\entrant\migrations;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\EntrantInWork;
use \yii\db\Migration;

class m191208_000128_add_entrant_in_work extends Migration
{
    private function table()
    {
        return EntrantInWork::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'job_entrant_id' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(0)
        ], $tableOptions);

        $this->createIndex('{{%idx-entrant_in_work-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-entrant_in_work-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-entrant_in_work-job_entrant}}', $this->table(), 'job_entrant_id');
        $this->addForeignKey('{{%fk-idx-entrant_in_work-job_entrant}}', $this->table(), 'job_entrant_id', JobEntrant::tableName(), 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
