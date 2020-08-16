<?php
namespace modules\dictionary\migrations;
use dictionary\models\DictDiscipline;
use modules\dictionary\models\DictExaminer;
use \yii\db\Migration;

class m191208_000039_add_table_examiner_discipline extends Migration
{
    private function table() {
        return 'examiner_discipline';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'examiner_id' => $this->integer()->notNull(),
            'discipline_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('examiner_discipline-primary', $this->table(),'discipline_id');
        $this->createIndex('{{%idx-examiner_discipline-examiner_id}}', $this->table(), 'examiner_id');
        $this->addForeignKey('{{%fk-idx-examiner_discipline-examiner_id}}', $this->table(), 'examiner_id', DictExaminer::tableName(), 'id',  'CASCADE', 'RESTRICT');
        $this->createIndex('{{%idx-examiner_discipline-discipline_id}}', $this->table(), 'discipline_id');
        $this->addForeignKey('{{%fk-examiner_discipline-discipline_id}}', $this->table(), 'discipline_id', DictDiscipline::tableName(),
            'id', 'CASCADE', 'RESTRICT');
    }



    public function down()
    {
        $this->dropTable($this->table());
    }
}
