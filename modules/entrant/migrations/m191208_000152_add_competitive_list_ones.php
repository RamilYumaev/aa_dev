<?php
namespace modules\entrant\migrations;

use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use \yii\db\Migration;

class m191208_000152_add_competitive_list_ones extends Migration
{
    private function table() {
        return 'competitive_list_ones';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            "cg_id" => $this->integer(),
            "fio" => $this->string(),
            "snils_or_id" => $this->string(),
            'exam_1' => $this->string(),
            'exam_2' => $this->string(),
            'exam_3' => $this->string(),
            'ball_exam_1' => $this->integer(3),
            'ball_exam_2' => $this->integer(3),
            'ball_exam_3' => $this->integer(3),
            'mark_ai' =>  $this->integer(3),
            'sum_ball' => $this->integer(3),
            'priority' => $this->integer(),
            'status' => $this->integer(1)->defaultValue(0),
            'is_recommend_transfer' => $this->boolean()
        ], $tableOptions);

        $this->createIndex('{{%idx-'.$this->table().'-snils_or_id}}', $this->table(), 'snils_or_id');
        $this->createIndex('{{%idx-'.$this->table().'-mark_ai}}', $this->table(), 'mark_ai');
        $this->createIndex('{{%idx-'.$this->table().'-sum_ball}}', $this->table(), 'sum_ball');
        $this->createIndex('{{%idx-'.$this->table().'-priority}}', $this->table(), 'priority');
        $this->createIndex('{{%idx-'.$this->table().'-status}}', $this->table(), 'status');
        $this->createIndex('{{%idx-'.$this->table().'-is_recommend_transfer}}', $this->table(), 'is_recommend_transfer');
        $this->createIndex('{{%idx-'.$this->table().'-cg_id}}', $this->table(), 'cg_id');
        $this->addForeignKey('{{%fk-idx-'.$this->table().'-cg_id}}', $this->table(), 'cg_id', CompetitiveGroupOnes::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
