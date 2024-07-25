<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000158_entrant_2024_ss extends Migration
{
    private function table() {
        return "entrant_2024_ss";
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'quid' => $this->string()->null(),
            "fio" => $this->string(),
            "snils" => $this->string()->null(),
            "id_ss" => $this->string()->null(),
            "sex" => $this->string(),
            'nationality' => $this->string()->comment("Гражданство"),
            'type_doc' => $this->string()->null(),
            'series' => $this->string()->null()->comment('Серия'),
            'number' => $this->string()->null()->comment("Номер"),
            'date_of_birth' => $this->date()->null()->comment("Дата рождения"),
            'place_of_birth' => $this->string()->null()->comment("Место рождения"),
            'date_of_issue' => $this->date()->null()->comment("Дата выдачи"),
            'authority' => $this->string()->null()->comment("Кем выдан"),
            'division_code' => $this->string(7)->null()->comment("Код подразделения"),
            'email' => $this->string()->null(),
            'phone' => $this->string()->null(),
            'is_hostel' => $this->boolean()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
