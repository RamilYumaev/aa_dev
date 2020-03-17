<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000009_add_anketa extends Migration
{
    private function table() {
        return \modules\entrant\models\Anketa::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'citizenship_id' => $this->integer(3)->null()->comment('Гражданство'),
            'edu_finish_year' => $this->integer(3)->null()->comment('Год окончания учебной организации'),
            'current_edu_level' => $this->integer(3)->null()->comment('Текущий уроверь образования абитуриента'),
            'category_id' => $this->integer(3)->null()->comment('Категория абитуриента'),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-anketa-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-anketa-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'CASCADE');
        $this->createIndex('{{%idx-passport-citizenship}}', $this->table(), 'citizenship_id');
        $this->addForeignKey('{{%fk-idx-passport-citizenship}}', $this->table(), 'citizenship_id', \dictionary\models\Country::tableName(), 'id',  'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
