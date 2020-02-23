<?php

use \yii\db\Migration;

class m190124_119999_add_declination_fio extends Migration
{
    private function table() {
        return \common\auth\models\DeclinationFio::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'nominative' => $this->string()->null(),
            'genitive' => $this->string()->null(),
            'dative' => $this->string()->null(),
            'accusative' => $this->string()->null(),
            'ablative' => $this->string()->null(),
            'prepositional' => $this->string()->null(),
        ], $tableOptions);


        $this->createIndex('{{%idx-declination_fio-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-declination_fio-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
