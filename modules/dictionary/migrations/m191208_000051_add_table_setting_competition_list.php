<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000051_add_table_setting_competition_list extends Migration
{
    private function table() {
        return 'setting_competition_list';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'se_id' => $this->integer()->notNull(),
            'date_start' => $this->date()->notNull(),
            'date_end' => $this->date()->notNull(),
            'time_start' => $this->time()->notNull(),
            'time_end' => $this->time()->notNull(),
            'time_start_week' => $this->time()->notNull(),
            'time_start_end' => $this->time()->notNull(),
            'interval' => $this->integer()->notNull(),
            'weekends_work' => $this->json(),
            'weekends' => $this->json()
        ], $tableOptions);

        $this->addPrimaryKey('setting_competition_list-primary', $this->table(), ['se_id']);

        $this->createIndex('{{%idx-setting_competition_list-se_id}}', $this->table(), 'se_id');
        $this->addForeignKey('{{%fk-idx-setting_competition_list-se_id}}', $this->table(), 'se_id', SettingEntrant::tableName(), 'id',  'RESTRICT', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
