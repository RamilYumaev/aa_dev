<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000018_update_date_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'date', $this->date()->null()->comment("От"));
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'date', $this->string()->null()->comment("Кем выдан"));
    }
}
