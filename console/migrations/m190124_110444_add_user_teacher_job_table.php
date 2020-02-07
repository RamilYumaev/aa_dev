<?php

use \yii\db\Migration;

class m190124_110444_add_user_teacher_job_table extends Migration
{
    private function table() {
        return \teacher\models\UserTeacherJob::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'school_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);


        $this->createIndex('{{%idx-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-school_id}}', $this->table(), 'school_id');
        $this->addForeignKey('{{%fk-idx-school_id}}', $this->table(), 'school_id', \dictionary\models\DictSchools::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
