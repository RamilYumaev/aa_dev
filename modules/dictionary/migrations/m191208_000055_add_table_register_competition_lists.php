<?php
namespace modules\dictionary\migrations;
use modules\dictionary\models\SettingEntrant;
use \yii\db\Migration;

class m191208_000055_add_table_register_competition_lists extends Migration
{
    private function table() {
        return 'register_competition_list';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'number_update' => $this->integer()->notNull(),
            'type_update' => $this->integer()->notNull(),
            'se_id' => $this->integer()->notNull(),
            'ais_cg_id'=> $this->integer()->notNull(),
            'date'=> $this->date()->notNull(),
            'time'=> $this->time()->notNull(),
            'status' => $this->integer()->notNull(),
            'error_message' => $this->string()->defaultValue('')
        ], $tableOptions);

        $this->createIndex('{{%idx-register_competition_list-se_id}}', $this->table(), 'se_id');
        $this->addForeignKey('{{%fk-idx-register_competition_list-se_id}}', $this->table(), 'se_id', SettingEntrant::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
