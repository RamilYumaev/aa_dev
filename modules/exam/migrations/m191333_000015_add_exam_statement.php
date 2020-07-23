<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000015_add_exam_statement extends Migration
{
    private function table() {
        return 'exam_statement';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer()->notNull(),
            'entrant_user_id' => $this->integer()->notNull(),
            'proctor_user_id' => $this->integer()->null(),
            'src_bbb' => $this->string()->null(),
            'status' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('{{%idx-exam_statement-exam_id}}', $this->table(), 'exam_id');
        $this->addForeignKey('{{%fk-exam_statement-exam_id}}', $this->table(), 'exam_id', 'exam', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_statement-entrant_user_id}}', $this->table(), 'entrant_user_id');
        $this->addForeignKey('{{%fk-idx-exam_statement-entrant_user_id}}', $this->table(), 'entrant_user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_statement-proctor_user_id}}', $this->table(), 'proctor_user_id');
        $this->addForeignKey('{{%fk-idx-exam_statement-proctor_user_id}}', $this->table(), 'proctor_user_id', \common\auth\models\User::tableName(), 'id',  'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
