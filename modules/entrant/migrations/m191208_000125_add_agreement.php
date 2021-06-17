<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use \yii\db\Migration;

class m191208_000125_add_agreement extends Migration
{
    private function table() {
        return \modules\entrant\models\Agreement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'work_organization_id' , $this->integer()->null()->comment('Организация работодателя'));
        $this->createIndex('{{%idx-agreement-work_organization_id}}', $this->table(), 'work_organization_id');
        $this->addForeignKey('{{%fk-idx-agreement-work_organization_id}}', $this->table(), 'work_organization_id', DictOrganizations::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
