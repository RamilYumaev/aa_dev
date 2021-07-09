<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000129_drop_columns_additional_information extends Migration
{
    private function table() {
        return AdditionalInformation::tableName();
    }

    public function up()
    {
       $this->dropColumn($this->table(), 'uid_epgu');
    }
}
