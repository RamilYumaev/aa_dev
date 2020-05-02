<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000031_add_univer_choice extends Migration
{
    private function table() {
        return \modules\entrant\models\Anketa::tableName();
    }

    public function up()
    {
        $this
            ->addColumn($this->table(), "university_choice", $this->integer()
            ->notNull()->comment("Выбор между головным вузом и филалами"));

    }

    public function down()
    {
        $this->dropColumn($this->table(), "university_choice");
    }
}
