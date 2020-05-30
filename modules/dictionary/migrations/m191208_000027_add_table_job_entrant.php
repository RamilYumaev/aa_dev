<?php
namespace modules\dictionary\migrations;

use dictionary\models\Faculty;
use modules\dictionary\models\JobEntrant;
use \yii\db\Migration;

class m191208_000027_add_table_job_entrant extends Migration
{
    private function table() {
        return JobEntrant::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer(2)->notNull(),
            'faculty_id' => $this->integer()->null(),
            'status' => $this->integer(1)->defaultValue(0)
        ], $tableOptions);

        $this->createIndex('{{%idx-job_entrant-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-job_entrant-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-job_entrant-faculty}}', $this->table(), 'faculty_id');
        $this->addForeignKey('{{%fk-job_entrant-faculty}}', $this->table(), 'faculty_id', Faculty::tableName(), 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
