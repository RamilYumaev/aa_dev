<?php

use \yii\db\Migration;

class m191208_000026_add_columns_dict_cg extends Migration
{

    public function up()
    {
        $this->addColumn(\dictionary\models\DictCompetitiveGroup::tableName(), 'success_speciality', $this->json());
    }

    public function down()
    {
        echo "";
    }
}
