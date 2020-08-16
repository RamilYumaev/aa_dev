<?php

namespace modules\exam\migrations;
use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamResult;
use yii\db\Migration;

class m191334_000019_add_colums_result extends Migration
{
    private function table() {
        return ExamResult::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'note', $this->text()->null());
    }
}
