<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000088_add_columns_information extends Migration
{
    private function table() {
        return \modules\entrant\models\AdditionalInformation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'exam_check', $this->integer(1)->defaultValue(0)->comment("Согласие экзамена"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'exam_check');
    }
}
