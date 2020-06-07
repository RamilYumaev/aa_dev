<?php

namespace modules\entrant\migrations;
use common\auth\models\User;
use \yii\db\Migration;

class m191208_000057_add_personal_entity extends Migration
{
    private function table() {
        return 'personal_entity';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'fio' => $this->string()->notNull(),
            'postcode' => $this->string()->notNull(),
            'address' => $this->text()->notNull(),
            'series' => $this->string()->null()->comment('Серия'),
            'number' => $this->string()->null()->comment("Номер"),
            'date_of_issue' => $this->date()->null()->comment("Дата выдачи"),
            'authority' => $this->string()->null()->comment("Кем выдан"),
            'phone' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-personal_entity-user_id}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-personal_entity-user_id}}', $this->table(), 'user_id', User::tableName(),
            'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
