<?php

namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000020_add_field_into_cg extends Migration
{

    public function up()
    {
        $this->addColumn('{{%dict_competitive_group}}', 'foreigner_status',
            $this->Integer(2)->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%dict_competitive_group}}', 'foreigner_status');

    }
}
