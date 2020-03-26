<?php
namespace modules\dictionary\migrations;

use modules\dictionary\models\CgExamAis;
use \yii\db\Migration;

class m191208_000021_add_cg_exam_ais extends Migration
{
    private function table() {
        return CgExamAis::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'competitive_group_id' => $this->integer(3)->notNull()->comment('Конкурсная группа АИС'),
            'entrance_examination_id' => $this->integer(3)->notNull()->comment('Экзамен'),
            'priority' => $this->integer(1)->comment('Составная дисциплина'),
            'year' => $this->integer(11)->comment('Год'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
