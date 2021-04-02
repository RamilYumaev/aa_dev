<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000102_rename_univer_choice extends Migration
{
    private function table() {
        return \modules\entrant\models\Anketa::tableName();
    }

    public function up()
    {
        $this
            ->alterColumn($this->table(), "university_choice", $this->integer()
            ->null()->comment("Выбор между головным вузом и филалами"));

    }

    public function down()
    {
        $this->dropColumn($this->table(), "university_choice");
    }
}
