<?php

use \yii\db\Migration;

class m190124_110446_add_and_drop_columns_in_table_dict_school extends Migration
{
    private function table() {
        return \dictionary\models\DictSchools::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'email');
        $this->dropColumn($this->table(), 'status');

        $this->addColumn($this->table(), 'dict_school_report_id', $this->integer()->null());

        $this->createIndex('{{%idx-dict_school_report_id}}', $this->table(), 'dict_school_report_id');
        $this->addForeignKey('{{%fk-idx-dict_school_report_id}}', $this->table(), 'dict_school_report_id', \dictionary\models\DictSchoolsReport::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->addColumn($this->table(), 'email', $this->string()->null()->unique());
        $this->addColumn($this->table(), 'status', $this->integer()->defaultValue(0));
        $this->dropColumn($this->table(), 'dict_school_report_id');

    }
}
