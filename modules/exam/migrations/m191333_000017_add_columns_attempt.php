<?php

namespace modules\exam\migrations;
use modules\exam\models\ExamAttempt;
use yii\db\Migration;

class m191333_000017_add_columns_attempt extends Migration
{
    private function table() {
        return ExamAttempt::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'type', $this->integer()->defaultValue(0));
    }
}
