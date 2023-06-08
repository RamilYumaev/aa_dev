<?php
namespace modules\transfer\migrations;

use modules\transfer\models\PassExam;
use \yii\db\Migration;

class m191305_000049_pas_exam_statement extends Migration
{
    private function table() {
        return 'pass_exam_statement';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'pass_exam_id'=>$this->integer(),
        ], $tableOptions);

        $this->createIndex('{{%idx-pass_exam_statement-pass-exam-id}}', $this->table(), 'pass_exam_id');
        $this->addForeignKey('{{%fx-pass_exam_statement-pass-exam-id}}', $this->table(), 'pass_exam_id', PassExam::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
