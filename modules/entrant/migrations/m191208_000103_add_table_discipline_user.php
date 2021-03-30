<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000103_add_table_discipline_user extends Migration
{
    private function table() {
        return  'discipline_user';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->integer(2)->null()->comment("Тип"),
            'discipline_id' => $this->integer()->notNull(),
            'discipline_select_id' => $this->integer()->notNull(),
            'mark' => $this->integer(3)->defaultValue(0),
            'year' => $this->string(4)->notNull(),
            'status_cse' => $this->integer(2)->defaultValue(0)->comment("Статус ЕГЭ")
        ], $tableOptions);
        
        $this->createIndex('{{%idx-discipline_user-user_id}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-discipline_user-user_id}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-discipline_user-discipline_select_id}}', $this->table(), 'discipline_select_id');
        $this->addForeignKey('{{%fk-idx-discipline_user-discipline_select_id}}', $this->table(), 'discipline_select_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%idx-discipline_user-discipline_id}}', $this->table(), 'discipline_id');
        $this->addForeignKey('{{%fk-idx-discipline_user-discipline_id}}', $this->table(), 'discipline_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
