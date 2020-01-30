<?php

use \yii\db\Migration;

class m190124_110218_add_range_column_to_table_olympiads_type_templates extends Migration
{
    private function table() {
        return \dictionary\models\OlimpiadsTypeTemplates::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'range', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'range');
    }
}
