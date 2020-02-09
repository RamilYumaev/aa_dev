<?php

use \yii\db\Migration;

class  m190124_110444_add_dict_schools_report_table extends Migration
{
    private function table() {
        return \dictionary\models\DictSchoolsReport::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'country_id' => $this->integer()->null(),
            'region_id' => $this->integer()->null(),
            'email'=> $this->string()->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('{{%idx-region_id}}', $this->table(), 'region_id');
        $this->addForeignKey('{{%fk-idx-region}}', $this->table(), 'region_id', \dictionary\models\Region::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-country_id}}', $this->table(), 'country_id');
        $this->addForeignKey('{{%fk-idx-country_id}}', $this->table(), 'country_id', \dictionary\models\Country::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
