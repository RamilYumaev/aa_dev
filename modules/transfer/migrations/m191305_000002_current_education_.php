<?php


namespace modules\transfer\migrations;


use yii\db\Migration;

class m191305_000002_current_education_ extends Migration
{
    private function table() {
        return 'current_education';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'school_id' => $this->integer()->null(),
            'user_id' =>  $this->integer()->null(),
            'speciality' => $this->string()->notNull(),
            'finance' => $this->integer(1)->notNull(),
            'course' => $this->integer()->notNull(),
            'form' => $this->integer(1)->notNull(),
            'edu_count' => $this->integer(1)->notNull(),
            'current_analog' => $this->boolean(),
        ], $tableOptions);

        $this->createIndex('{{%idx-current_education-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-current_education-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-current_education-school_id}}', $this->table(), 'school_id');
        $this->addForeignKey('{{%fk-idx-current_education-school_id}}', $this->table(), 'school_id', \dictionary\models\DictSchools::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
