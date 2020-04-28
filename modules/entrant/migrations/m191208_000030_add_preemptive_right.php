<?php
namespace modules\entrant\migrations;

use modules\dictionary\models\DictOrganizations;
use modules\entrant\models\OtherDocument;
use \yii\db\Migration;

class m191208_000030_add_preemptive_right extends Migration
{
    private function table() {
        return \modules\entrant\models\PreemptiveRight::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'other_id' => $this->integer()->notNull(),
            'type_id' => $this->integer(2)->notNull(),
            'statue_id' => $this->integer(1)->null(),
        ], $tableOptions);
        
        $this->createIndex('{{%idx-preemptive_right-other_id-type_id}}', $this->table(), ['other_id','type_id'], true);
        $this->addForeignKey('{{%fk-idx-preemptive_right-other_id}}', $this->table(), 'other_id', OtherDocument::tableName(), 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
