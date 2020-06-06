<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000056_add_columns_statement_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementCg::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'count_pages', $this->integer()->defaultValue(0)->comment("количество страниц"));

    }

    public function down()
    {
        $this->dropColumn($this->table(), 'count_pages');
    }
}
