<?php

use \yii\db\Migration;

class m190124_110566_add_and_drop_columns_in_table_dict_school_report extends Migration
{
    private function table() {
        return \dictionary\models\DictSchoolsReport::tableName();
    }

    public function up()
    {
        $this->dropForeignKey('fk-idx-region', $this->table());
        $this->dropIndex('idx-region_id', $this->table());
        $this->dropForeignKey('fk-idx-country_id', $this->table());
        $this->dropIndex('idx-country_id', $this->table());

        $this->dropColumn($this->table(), "name");
        $this->dropColumn($this->table(), "country_id");
        $this->dropColumn($this->table(), "region_id");
        $this->dropColumn($this->table(), "email");
        $this->dropColumn($this->table(), "status");

        $this->addColumn($this->table(), 'school_id', $this->integer()->null()->unique());

        $this->createIndex('{{%idx-school_id_report}}', $this->table(), 'school_id');
        $this->addForeignKey('{{%fk-idx-school_id_report}}', $this->table(), 'school_id', \dictionary\models\DictSchools::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {

    }
}
