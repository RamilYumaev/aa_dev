<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000017_add_columns_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'series', $this->string()->null()->comment("Серия"));
        $this->addColumn($this->table(), 'number', $this->string()->null()->comment("Номер"));
        $this->addColumn($this->table(), 'date', $this->string()->null()->comment("От"));
        $this->addColumn($this->table(), 'authority', $this->string()->null()->comment("Кем выдан"));
        $this->addColumn($this->table(), 'amount', $this->string()->null()->comment("Количество"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'series');
        $this->dropColumn($this->table(), 'number');
        $this->dropColumn($this->table(), 'date');
        $this->dropColumn($this->table(), 'authority');
        $this->dropColumn($this->table(), 'amount');
    }
}
