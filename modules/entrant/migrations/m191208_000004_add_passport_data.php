<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000004_add_passport_data extends Migration
{
    private function table() {
        return \modules\entrant\models\PassportData::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nationality' => $this->integer()->notNull()->comment("Гражданство"),
            'type' => $this->integer(3)->null()->comment('Тип документа'),
            'series' => $this->string()->null()->comment('Серия'),
            'number' => $this->string()->null()->comment("Номер"),
            'date_of_birth' => $this->date()->null()->comment("Дата рождения"),
            'place_of_birth' => $this->string()->null()->comment("Место рождения"),
            'date_of_issue' => $this->date()->null()->comment("Дата выдачи"),
            'authority' => $this->string()->null()->comment("Кем выдан"),
            'division_code' => $this->string(7)->null()->comment("Код подразделения"),
        ], $tableOptions);


        $this->createIndex('{{%idx-passport-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-passport-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-passport-nationality}}', $this->table(), 'nationality');
        $this->addForeignKey('{{%fk-idx-passport-nationality}}', $this->table(), 'nationality', \dictionary\models\Country::tableName(), 'id',  'RESTRICT', 'RESTRICT');
        $this->createIndex('{{%idx-passport-type}}', $this->table(), 'type');
        $this->addForeignKey('{{%fk-idx-passport-type}}', $this->table(), 'type', \modules\entrant\models\dictionary\DictIncomingDocumentType::tableName(),
            'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
