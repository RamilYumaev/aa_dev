<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000001_add_exam extends Migration
{
    private function table() {
        return 'exam';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'discipline_id' => $this->integer()->notNull(),
            'date_start' => $this->date()->notNull(),
            'date_end' => $this->date()->notNull(),
            'time_start' => $this->time()->notNull(),
            'time_end' => $this->date()->notNull(),
            'time_exam' => $this->integer()->notNull(),
            'date_start_reserve' => $this->date()->null(),
            'date_end_reserve' => $this->date()->null(),
            'time_start_reserve' => $this->time()->null(),
            'time_end_reserve' => $this->date()->null(),
        ], $tableOptions);


        $this->createIndex('{{%idx-exam-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-exam-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-exam-discipline_id}}', $this->table(), 'discipline_id');
        $this->addForeignKey('{{%fk-idx-exam-discipline_id}}', $this->table(), 'discipline_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
