<?php

use \yii\db\Migration;

class m190124_110216_add_column_year_to_test_group_question_table extends Migration
{
    private function table() {
        return \testing\models\TestQuestionGroup::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'year', $this->string()->notNull()->defaultValue("2018-2019"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'year');
    }
}
