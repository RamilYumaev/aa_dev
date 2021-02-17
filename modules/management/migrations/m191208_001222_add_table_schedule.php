<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001222_add_table_schedule extends Migration
{
    private function table() {
        return Schedule::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'monday' => $this->string(11)->notNull()->defaultValue(''),
            'tuesday' => $this->string(11)->notNull()->defaultValue(''),
            'wednesday' => $this->string(11)->notNull()->defaultValue(''),
            'thursday' => $this->string(11)->notNull()->defaultValue(''),
            'friday' => $this->string(11)->notNull()->defaultValue(''),
            'saturday' => $this->string(11)->notNull()->defaultValue(''),
            'sunday' => $this->string(11)->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->createIndex('{{%idx-schedule-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-schedule-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
