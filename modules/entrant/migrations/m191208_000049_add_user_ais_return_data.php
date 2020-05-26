<?php
namespace modules\entrant\migrations;

use common\auth\models\User;
use modules\dictionary\models\DictOrganizations;
use modules\entrant\models\AisReturnData;
use modules\entrant\models\OtherDocument;
use \yii\db\Migration;

class m191208_000049_add_user_ais_return_data extends Migration
{
    private function table() {
        return AisReturnData::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'created_id' => $this->integer()->notNull(),
            'incoming_id' => $this->integer()->notNull(),
            'model' => $this->string()->null(),
            'model_type'=> $this->integer()->null(),
            'record_id_sdo' => $this->integer()->notNull(),
            'record_id_ais' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ], $tableOptions);

        $this->createIndex('{{%idx-return_data-created_id}}', $this->table(), 'created_id');
        $this->addForeignKey('{{%fk-idx-return_data-created_id}}', $this->table(), 'created_id', User::tableName(), 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
