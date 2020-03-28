<?php

namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000022_add_field_into_cg_exam extends Migration
{

    public function up()
    {

        $this->addColumn('{{%dict_discipline}}', 'ais_cg',
            $this->Integer(7)->defaultValue(null));
    }

    public function down()
    {

        $this->dropColumn('{{%dict_discipline}}', 'ais_cg');
    }
}
