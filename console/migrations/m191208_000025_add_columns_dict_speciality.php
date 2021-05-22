<?php

use \yii\db\Migration;

class m191208_000025_add_columns_dict_speciality extends Migration
{

    public function up()
    {
        $this->addColumn(\dictionary\models\DictSpeciality::tableName(), 'edu_level', $this->integer(1)->defaultValue(0));
    }

    public function down()
    {
        echo "";
    }
}
