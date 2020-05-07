<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use \yii\db\Migration;

class m191208_000037_add_fio_latin extends Migration
{
    private function table() {
        return \modules\entrant\models\FIOLatin::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            "surname" => $this->string()->null()->comment("Фамилия"),
            'name'=> $this->string()->null()->comment("Имя"),
            "patronymic"=> $this->string()->null()->comment("Отчество"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-fio_latin-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-fio_latin-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
