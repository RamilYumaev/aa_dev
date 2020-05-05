<?php
namespace modules\entrant\migrations;
use modules\entrant\models\Anketa;
use \yii\db\Migration;

class m191208_000034_add_column_provinces_num extends Migration
{
    private function table() {
        return Anketa::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "province_of_china", $this->string("25")
            ->defaultValue(null)
            ->comment("Провинция Китая"));
        $this->addColumn($this->table(), "personal_student_number", $this->string("25")
            ->defaultValue(null)
            ->comment("Персональный номер абитуриента по гослинии"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'province_of_china');
        $this->dropColumn($this->table(), 'personal_student_number');

    }
}
