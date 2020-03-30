<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000015_add_column_document_education extends Migration
{
    private function table() {
        return \modules\entrant\models\DocumentEducation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'original', $this->integer(1)->null()->comment("Оригинал"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'original');
    }
}
