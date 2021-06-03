<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000003_current_education_info_ extends Migration
{
    private function table() {
        return 'current_education_info';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' =>  $this->integer()->null(),
            'year' => $this->integer(4),
            'faculty' => $this->string()->notNull(),
            'finance' => $this->integer(1)->notNull(),
            'specialization' => $this->string()->notNull(),
            'form' => $this->integer(1)->notNull(),
            'course' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-current_education_info-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-current_education_info-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
