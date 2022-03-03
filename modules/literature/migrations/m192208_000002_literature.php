<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000002_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'birthday' => $this->date()->notNull(),
            'type' => $this->smallInteger(1)->notNull(),
            'series' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'date_issue' => $this->string()->notNull(),
            'authority'=> $this->string()->notNull(),
            'region' =>  $this->string()->notNull(),
            'zone' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'full_name' => $this->string()->notNull(),
            'short_name' => $this->string()->notNull(),
            'status_olympic' => $this->integer(1)->notNull(),
            'mark_olympic' => $this->string(5)->notNull(),
            'grade_number' => $this->integer(2)->notNull(),
            'grade_letter' => $this->string(1)->null(),
            'grade_performs' => $this->integer(2)->notNull(),
            'fio_teacher' => $this->string()->notNull(),
            'place_work' => $this->string()->notNull(),
            'post' => $this->string()->notNull(),
            'academic_degree' => $this->string()->null(),
            'size' => $this->string()->notNull(),
            'is_allergy' => $this->boolean(),
            'note_allergy' => $this->text(),
            'is_voz' => $this->boolean(),
            'is_need_conditions' => $this->boolean(),
            'note_conditions' => $this->text(),
            'note_special' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-literature_olympic-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-literature_olympic-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
