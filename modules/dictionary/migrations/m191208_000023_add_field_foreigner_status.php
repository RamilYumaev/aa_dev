<?php

namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000023_add_field_foreigner_status extends Migration
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
