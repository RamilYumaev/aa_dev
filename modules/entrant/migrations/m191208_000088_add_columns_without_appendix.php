<?php
namespace modules\entrant\migrations;
use modules\entrant\models\DocumentEducation;
use \yii\db\Migration;

class m191208_000088_add_columns_without_appendix extends Migration
{
    private function table() {
        return DocumentEducation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'without_appendix', $this->integer(1)->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'without_appendix');
    }
}
