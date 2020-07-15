<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000009_add_exam_attempt extends Migration
{
    private function table() {
        return 'exam_attempt';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer()->notNull(),
            'test_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'start' => $this->dateTime()->notNull(),
            'end' => $this->dateTime()->null(),
            'mark' => $this->decimal(4,1)->null(),
            'status' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('{{%idx-exam_attempt-exam_id}}', $this->table(), 'exam_id');
        $this->addForeignKey('{{%fk-exam_attempt-exam_id}}', $this->table(), 'exam_id', 'exam', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_attempt-user}}', $this->table(), 'user_id');
        $this->addForeignKey('{{%fk-idx-exam_attempt-user}}', $this->table(), 'user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_attempt-test_id}}', $this->table(), 'test_id');
        $this->addForeignKey('{{%fk-exam_attempt-test_id}}', $this->table(), 'test_id', 'exam_test', 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
