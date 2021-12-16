<?php

namespace modules\transfer\migrations;

use dictionary\models\DictSpeciality;
use dictionary\models\Faculty;
use modules\entrant\models\StatementCg;
use \yii\db\Migration;

class m191305_000033_add_columns_personal_entity extends Migration
{
    private function table()
    {
        return "personal_entity_transfer";
    }

    public function up()
    {
       //$this->addColumn($this->table(),  'postcode', $this->string()->null()->comment('Индекс'));
       $this->dropColumn($this->table(), 'address');
       $this->addColumn($this->table(),  'region' , $this->string()->null()->comment("Регион"));
       $this->addColumn($this->table(),  'district' , $this->string()->null()->comment("Район"));
       $this->addColumn($this->table(),  'city' , $this->string()->null()->comment("Город"));
       $this->addColumn($this->table(),  'village' , $this->string()->null()->comment("Посёлок"));
       $this->addColumn($this->table(),  'street' , $this->string()->null()->comment("Улица"));
       $this->addColumn($this->table(),  'house' , $this->string()->null()->comment("Дом"));
       $this->addColumn($this->table(),  'housing' , $this->string()->null()->comment("Корпус"));
       $this->addColumn($this->table(),  'building' , $this->string()->null()->comment("Строение"));
       $this->addColumn($this->table(),  'flat' , $this->string()->null()->comment("Квартира"));

    }

    public function down()
    {

    }
}
