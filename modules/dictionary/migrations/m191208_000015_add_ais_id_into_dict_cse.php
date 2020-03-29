<?php
namespace modules\dictionary\migrations;

use \yii\db\Migration;

class m191208_000015_add_ais_id_into_dict_cse extends Migration
{
    public function up()
    {
        $this->addColumn("dict_cse_subject", 'ais_id', $this->integer(5)
            ->null()->comment("Id АИС ВУЗ"));
    }

    public function down()
    {
        $this->dropColumn("dict_cse_subject", "ais_id");
    }
}