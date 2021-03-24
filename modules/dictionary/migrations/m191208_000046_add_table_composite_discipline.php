<?php
namespace modules\dictionary\migrations;

use dictionary\models\DictDiscipline;
use Yii;
use \yii\db\Migration;

class m191208_000046_add_table_composite_discipline extends Migration
{
    private function table() {
        return 'composite_discipline';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'discipline_id' => $this->integer()->notNull(),
            'discipline_select_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('composite_discipline-primary', $this->table(), ['discipline_id', 'discipline_select_id']);

        $this->createIndex('{{%idx-composite_discipline-discipline_select_id}}', $this->table(), 'discipline_select_id');
        $this->addForeignKey('{{%fk-idx-composite_discipline-discipline_select_id}}', $this->table(), 'discipline_select_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');

        $this->createIndex('{{%idx-composite_discipline-discipline_id}}', $this->table(), 'discipline_id');
        $this->addForeignKey('{{%fk-idx-composite_discipline-discipline_id}}', $this->table(), 'discipline_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}