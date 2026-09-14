<?php

namespace modules\transfer\migrations;
use \yii\db\Migration;

class m260914_141500_add_table_setting_transfer extends Migration
{
    public function safeUp()
    {
        $this->addColumn('transfer_mpgu','citizenship_id', $this->integer(3)->null()->comment('Гражданство'));

        $this->createIndex('{{%idx-transfer_mpgu-citizenship}}', 'transfer_mpgu', 'citizenship_id');
        $this->addForeignKey('{{%fk-idx-transfer_mpgu-citizenship}}', 'transfer_mpgu', 'citizenship_id', \dictionary\models\Country::tableName(), 'id',  'CASCADE', 'CASCADE');

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('transfer_setting', [
            'id' => $this->primaryKey(),
            'finances' => $this->json(),
            'citizenship'  => $this->json(),
            'semesters'  => $this->json(),
            'date_start'  => $this->dateTime(),
            'date_end'  => $this->dateTime(),
        ], $tableOptions);
    }

    public function safeDown()
    {
    }
}
