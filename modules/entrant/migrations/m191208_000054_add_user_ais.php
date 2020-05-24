<?php
namespace modules\entrant\migrations;

use common\auth\models\User;
use modules\dictionary\models\DictOrganizations;
use modules\entrant\models\OtherDocument;
use \yii\db\Migration;

class m191208_000054_add_user_ais extends Migration
{
    private function table() {
        return 'user_ais';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'user_id' => $this->integer()->notNull(),
            'incoming_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_ais-user_id-incoming}}', $this->table(), ['user_id','incoming_id'], true);
        $this->addForeignKey('{{%fk-idx-user_ais-user_id}}', $this->table(), 'user_id', User::tableName(), 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
