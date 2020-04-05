<?php
namespace modules\entrant\migrations;
use modules\dictionary\models\DictOrganizations;
use \yii\db\Migration;

class m191208_000019_add_column_user_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\UserCg::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'organization_id', $this->integer()->null()->comment("Целевая организация"));
        $this->createIndex('{{%idx-user_cg-organization_id}}', $this->table(), 'organization_id');
        $this->addForeignKey('{{%fk-idx-user_cg-organization_id}}', $this->table(), 'organization_id', DictOrganizations::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('{{%fk-idx-user_cg-organization_id}}',$this->table());
        $this->dropIndex('{{%idx-user_cg-organization_id}}',$this->table());
        $this->dropColumn($this->table(),  'organization_id');
    }
}
