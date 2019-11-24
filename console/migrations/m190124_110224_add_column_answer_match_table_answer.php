<?php

use \yii\db\Migration;

class m190124_110224_add_column_answer_match_table_answer extends Migration
{
    public function up()
    {
        $this->addColumn('answer', 'answer_match', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn('answer', 'answer_match');
    }
}
