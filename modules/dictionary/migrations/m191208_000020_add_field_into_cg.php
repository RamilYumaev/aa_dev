<?php

namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000020_add_field_into_cg extends Migration
{

    public function up()
    {
        $this->addColumn('{{%dict_competitive_group}}', 'education_year_cost',
            $this->decimal(9, 2)->defaultValue(null));

        $this->addColumn('{{%dict_competitive_group}}', 'enquiry_086_u_status',
            $this->tinyInteger(1)->defaultValue(0));

        $this->addColumn('{{%dict_competitive_group}}', 'spo_class',
            $this->tinyInteger(3)->defaultValue(null));

        $this->addColumn('{{%dict_competitive_group}}', 'discount',
            $this->decimal(3, 1)->defaultValue(0.0));

        $this->addColumn('{{%dict_competitive_group}}', 'ais_cg',
            $this->Integer(7)->defaultValue(null));
    }

    public function down()
    {
        $this->dropColumn('{{%dict_competitive_group}}', 'education_year_cost');

        $this->dropColumn('{{%dict_competitive_group}}', 'enquiry_086_u_status');

        $this->dropColumn('{{%dict_competitive_group}}', 'spo_class');

        $this->dropColumn('{{%dict_competitive_group}}', 'discount');

        $this->dropColumn('{{%dict_competitive_group}}', 'ais_cg');
    }
}
