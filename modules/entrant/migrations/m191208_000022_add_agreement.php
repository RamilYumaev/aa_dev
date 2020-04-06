<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use \yii\db\Migration;

class m191208_000022_add_agreement extends Migration
{
    private function table() {
        return \modules\entrant\models\Agreement::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'organization_id' => $this->integer()->notNull()->comment('Организация'),
            'number' => $this->string()->null()->comment("Номер"),
            'date' => $this->date()->null()->comment("От"),
            'year' => $this->string()->null()->comment("Год"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-agreement-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-agreement-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-agreement-organization_id}}', $this->table(), 'organization_id');
        $this->addForeignKey('{{%fk-idx-agreement-organization_id}}', $this->table(), 'organization_id', DictOrganizations::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
