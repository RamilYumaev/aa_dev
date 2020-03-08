<?php
namespace modules\entrant\migrations;

use modules\entrant\models\Address;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\PassportData;
use \yii\db\Migration;

class m191208_000001_drop_tables extends Migration
{

    public function up()
    {
        $this->dropTable(Address::tableName());
        $this->dropTable(PassportData::tableName());
        $this->dropTable(DocumentEducation::tableName());
    }

    public function down()
    {

    }
}
