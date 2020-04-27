<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use \yii\db\Migration;

class m191208_000029_add_additional_information extends Migration
{
    private function table() {
        return \modules\entrant\models\AdditionalInformation::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'resource_id' => $this->integer()->notNull(),
            'voz_id' => $this->integer(1)->null()->comment('ВОЗ'),
            'hostel_id' => $this->string(1)->null()->comment("Общежитие?"),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-additional_information-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-additional_information-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
