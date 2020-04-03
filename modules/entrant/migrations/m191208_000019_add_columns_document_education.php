<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000019_add_columns_document_education extends Migration
{
    private function table() {
        return \modules\entrant\models\DocumentEducation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "surname", $this->string()->null()->comment("Фамилия"));
        $this->addColumn($this->table(), 'name', $this->string()->null()->comment("Имя"));
        $this->addColumn($this->table(), "patronymic", $this->string()->null()->comment("Отчество"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), "surname");
        $this->dropColumn($this->table(), "name");
        $this->dropColumn($this->table(), "patronymic");
    }
}
