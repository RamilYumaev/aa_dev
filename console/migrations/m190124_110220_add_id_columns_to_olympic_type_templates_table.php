<?php

use \yii\db\Migration;

class m190124_110220_add_id_columns_to_olympic_type_templates_table extends Migration
{
    private function table() {
        return \dictionary\models\OlimpiadsTypeTemplates::tableName();
    }

    public function up()
    {
        $this->dropPrimaryKey('PRIMARY', $this->table());
        $this->addColumn($this->table(), 'id', $this->primaryKey()->first());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'id');
        $this->addPrimaryKey("primaries-key", $this->table(), ["number_of_tours","form_of_passage",
            "edu_level_olimp", "template_id" ]);
    }
}
