<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use \yii\db\Migration;

class m191208_000124_add_agreement extends Migration
{
    private function table() {
        return \modules\entrant\models\Agreement::tableName();
    }

    public function up()
    {
      return $this->alterColumn($this->table(),'organization_id', $this->integer()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
