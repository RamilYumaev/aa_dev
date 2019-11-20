<?php

use \yii\db\Migration;

class m190124_110218_add_year_columns_to_table_olympiads_type_templates extends Migration
{
    private function table() {
        return \dictionary\models\OlimpiadsTypeTemplates::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'year', $this->string()->notNull()->defaultValue("2018-2019"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'year');
    }
}
