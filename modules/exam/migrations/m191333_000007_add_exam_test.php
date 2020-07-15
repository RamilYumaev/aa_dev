<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000007_add_exam_test extends Migration
{
    private function table() {
        return 'exam_test';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'introduction' => $this->text()->null(),
            'final_review' => $this->text()->null(),
            'status' => $this->integer()->defaultValue(0),
            'random_order' => $this->integer()->defaultValue(0)
        ], $tableOptions);




        $this->createIndex('{{%idx-exam_test-exam_id}}', $this->table(), 'exam_id');
        $this->addForeignKey('{{%fk-exam_test-exam_id}}', $this->table(), 'exam_id', 'exam', 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
