<?php

use \yii\db\Migration;

class m191208_000002_add_address extends Migration
{
    private function table() {
        return \modules\entrant\models\Address::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull()->comment("Страна"),
            'type' => $this->integer()->notNull()->comment('1 - фактический, 2 - постоянная, 3 - временная'),
            'postcode' => $this->string()->null()->comment('Индекс'),
            'region' => $this->string()->null()->comment("Регион"),
            'district' => $this->string()->null()->comment("Район"),
            'city' => $this->string()->null()->comment("Город"),
            'village' => $this->string()->null()->comment("Посёлок"),
            'street' => $this->string()->null()->comment("Улица"),
            'house' => $this->string()->null()->comment("Дом"),
            'housing' => $this->string()->null()->comment("Корпус"),
            'building' => $this->string()->null()->comment("Строение"),
            'flat' => $this->string()->null()->comment("Квартира"),
        ], $tableOptions);


        $this->createIndex('{{%idx-address-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-address-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-address-country_id}}', $this->table(), 'country_id');
        $this->addForeignKey('{{%fk-idx-address-country_id}}', $this->table(), 'country_id', \dictionary\models\Country::tableName(), 'id',  'RESTRICT', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
